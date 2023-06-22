import datetime
import pytz
import struct
import json

def ouverture(fic): #fonction permetant de d'ouvrir le fichier binaire prend en entré le nom du fichier binaire 
    with open(fic, "rb") as f: #ouvre le fichier 
        global binary   #rend la varible global 
        binary = f.read() #met dans la variable le contenu de mon fichier
    with open("./FT.json", "r") as fic:
        global FT
        FT = json.load(fic)
    return(FT)

#fonction permetant de chercher la valeur de la variable dans le fichier

def read_binary(octd, octf):  #prend en entreé la valeur en octet de début - 1 et la valeur en octet de fin   
    return (binary[octd: octf]) #renvoie un chiffre encodé 

#fonction permettant de décoder la valeur renvoyé donné par read_binary

def convert_deci(nb):  #prend en entré une valeur de read_binary
    dec_number = int.from_bytes(nb, byteorder='big', signed=False)
    return (dec_number) #renvoi une valeur en decimal 

#fonction permettant de lire et convertir 

def read_convert(octd, octf):
    return(convert_deci(read_binary(octd, octf)))

#fonction qui pemet de convertir frame date en utilisant le codage timestamp 1970

def date(nb): #prend en entré une valeur de read_binary
    nb = struct.unpack('>d', nb)[0] #utilise la fonction unpack de struct pour convertir la valeur en IEEE 754
    date_utc = datetime.datetime.utcfromtimestamp(nb) #converti la date 
    timezone = pytz.timezone('Europe/Paris') #definis l'utc demandé
    date_utc1 = timezone.localize(date_utc) #ajuste la date a l'utc 
    date_format = date_utc1.strftime('%d/%m/%Y %H:%M:%S.%f') #choisi la façon d'afficher la date 
    return date_format #renvoie la date au format jj/mm/aaaa ss/mm/hh

#fonction qui pemet de convertir frame date en utilisant le codage timestamp 2000

def date_2000(nb):
    date_2000 = datetime.datetime(2000, 1, 1, 12, 0, 0)# Ajoute le nombre de secondes à partir du 01/01/2000 à 12h00:00
    date = date_2000 + datetime.timedelta(seconds=nb)
    timezone = pytz.timezone('Europe/Paris') #definit l'UTC
    date_utc = timezone.localize(date).astimezone(pytz.utc) # Convertit la date en UTC
    date_format = date_utc.strftime('%d/%m/%Y %H:%M:%S.%f') # Formate la date
    return date_format

#fonction permetant de d'utiliser date

def read_date(octd, octf):
    return(date(read_binary(octd, octf)))

#fonction permettant de convertir une valeur decimal en adr MAC 

def adr_MAC(nb): #prend en entré une valeur de 6 octets de convert deci et 
    nb = hex(nb)[2:] #enleve les deux premieres valeurs parce que la fonction hex met un 0x pour montrer que la valeur est en hexa
    nb = nb.zfill(12) #rajoute des 0 devants car si il y en a ils sont enlevés par hex()
    list_MAC = []   
    for i in range (1,7):
        ip = nb[2*i-2 : 2*i].upper()
        list_MAC.append(ip)
    nb = ":".join(list_MAC) #permet de joindre tous les élémets de la liste par un point
    return(nb)  #renvoi l'adr MAC 

#fonction qui permet d'utiliser adr_MAC

def read_MAC(octd, octf):
    return(adr_MAC(read_convert(octd, octf)))

#fonction permettant de convertir une valeur decimal en adr IP

def adr_ip(octd, octf): #prend en entrée la valeur en octet début - 1 et la valeur en octet de fin
    list_ip = []
    for i in range (4):# fait une boucle qui marche 4 fois 
        oct = str(read_convert(octd, octd+1)) #converti chaque morceau de l'addresse ip et la converti en char
        octd = octd + 1
        list_ip.append(oct) #met tous dans une liste 
    ip = ".".join(list_ip) #join bout a bout tous les élements de la liste par un point 
    return(ip) #renvoie  l'adresse ip

#fonction permettant de lire les octets bits par bits 

def read_bytes(octd, octf, bitd, bitf): #prend en entrée l'octet de depart -1 et l'octet de fin et le bits de depart -1 et le bits de fin
    n = octf - octd #calcule ne nombre d'octet demandé
    nb = read_convert(octd, octf) #cherche la valeur en decimal des octets 
    nb_bin = str(bin(nb))[2:] #converti l'octet en binaire et le met enleve le 0b devant
    nb_bin = nb_bin.zfill(n*8) #remplis le nombre de bits necessaire par des 0 devants car enlevés au moment des conversions
    bit = nb_bin[bitd : bitf] # prends dans la chaine de caractère les octets demandés 
    nb = int(bit, 2) #converti le tout en decimal 
    return(nb) #renvoi la valeur en decimal

#fonction permettant de lire les données du .rep

def fichier(rep, cpter, cursor): #prend en entrée le nom du fichier
    with open(rep, "rb") as fic: #ouvre le fichier en binaire
        lines = fic.readlines() #lit chaque ligne 
        obsw = lines[7].decode().rstrip().split(": ")[1] + " " + lines[8].decode().rstrip().split(": ")[1] #concataine les 2 valeurs de obsw
        bds = lines[9].decode().rstrip().split(": ")[1]
        tv = lines[10].decode().rstrip().split(": ")[1]
        dt = lines[14].decode().rstrip().replace('"', '').split(": ")[1] #enleve les guillemets pour gérer les pb en csv
        nom = lines[27].decode().rstrip().split(": ")[1]
    request = """insert into fichier 
    (cpter, obsw, bds, tv, dte, nomFic)
    values (%s,%s,%s,%s,%s,%s)"""
    params =(cpter, obsw, bds, tv, dt, nom)
    cursor.execute(request, params)

#fonction permettant de verifier si une valeur a un equivalent pour une fonction de transfert

def fct_transfert(val, FT_choosen): #prend en entrée la valeu et la fonction de transfert associé a la valeure
    return FT_choosen.get(val, val)

def useft(octd, octf,  Fct, bd=0, bf=0):
    if  Fct != "FT_5" and Fct != "FT_1":
        value = "0x"+str(read_bytes(octd, octf, bd, bf)).zfill(2)
        return(fct_transfert(value, FT.get(Fct)))
    elif Fct == "FT_5":
        value = str(int(read_bytes(octd, octf, bd, bf)))
        return(fct_transfert(value, FT.get("FT_5")))
    elif Fct == "FT_1":
        value = str(read_convert(octd, octf))
        return(fct_transfert(value, FT.get("FT_1")))

def FT6(f14, f18, f28, f29, f30):
    string = int(str(bin(f14)[2:]) + str(bin(f18)[2:]).zfill(5) + str((bin(f28)[2:])).zfill(6) + str((bin(f29)[2:])).zfill(6) + str((bin(f30)[2:])).zfill(10), base=2)
    string = str(hex(string)[2:]).zfill(7).upper()
    string = "0x" + string
    return string

def made_cpter():
    with open("compteur.json", "r") as fic1:
        cpter = json.load(fic1)
    cpter = cpter + 1
    with open("compteur.json", "w") as fic2:
        json.dump(cpter, fic2)
    return cpter

