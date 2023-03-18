import datetime
import pytz
import struct

with open("ethernet.result_data", "rb") as fic:    
    binary = fic.read() 

#fonction permetant de chercher la valeur de la variable dans le fichier

def read_binary(octd, octf):  #prend en entreé la valeur en octet de but - 1 et la valeur en octet de fin   
    return (binary[octd: octf]) #renvoie un chiffre encodé 

#fonction permettant de décoder la valeur renvoyé donné par read_binary

def convert_deci(nb):  #prend en entré une valeur de read_binary
    dec_number = int.from_bytes(nb, byteorder='big', signed=False)
    return (dec_number) #renvoi une valeur en decimal 

#fonction permettant de lire et convertir 

def read_convert(octd, octf):
    return(convert_deci(read_binary(octd, octf)))

#fonction qui pemet de convertir frame date en utilisant le codage timestamp

def date(nb):  
    nb = struct.unpack('>d', nb)[0]  
    date = datetime.datetime.fromtimestamp(nb)  #utilise la fonction 
    date_format = date.strftime('%d/%m/%Y %H:%M:%S')
    return(date_format) 

def date(nb): #prend en entré une valeur de read_binary
    nb = struct.unpack('>d', nb)[0] #utilise la fonction unpack de struct pour convertir la valeur en IEEE 754
    date_utc = datetime.datetime.utcfromtimestamp(nb) #converti la date 
    timezone = pytz.timezone('Europe/Paris') #definis l'utc demandé
    date_utc1 = timezone.localize(date_utc) #ajuste la date a l'utc 
    date_format = date_utc1.strftime('%d/%m/%Y %H:%M:%S') #choisi la façon d'afficher la date 
    return date_format #renvoie la date au format jj/mm/aaaa ss/mm/hh

#fonction permetant de d'utiliser date

def read_date(octd, octf):
    return(date(read_binary(octd, octf)))

#fonction permettant de convertir une valeur decimal en adr MAC 

def adr_MAC(nb): #prend en entré une valeur de 6 octets de convert deci et 
    nb = hex(nb)[2:] #enleve les deux premieres valeurs parce que la fonction hex met un 0x pour montrer que la valeur est en hexa
    nb = nb.zfill(12) #rajoute des 0 devants car si il y en a ils sont enlevés par hex()
    list_MAC = []   
    for i in range (1,7):
        ip = nb[2*i-2 : 2*i]
        list_MAC.append(ip)
    nb = ".".join(list_MAC) #permet de joindre tous les élémets de la liste par un point
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
    return(ip) #renvoi l'adr ip

#fonction permettant de lire les octets bits par bits 

def read_bytes(octd, octf, bitd, bitf): #prend en entre l'octet de depart -1 et l'octet de fin et le bits de depart -1 et le bits de fin
    n = octf - octd #calcule ne nombre d'octet demandé
    nb = read_convert(octd, octf) #cherche la valeur en decimal des octets 
    nb_bin = str(bin(nb))[2:] #converti l'octet en binaire et le met enleve le 0b devant
    nb_bin = nb_bin.zfill(n*8) #remplis le nombre de bits necessaire par des 0 devants car enlevés au moment des converisons
    bit = nb_bin[bitd : bitf] # prends dans la chaine de charactère les octets demandés 
    nb = int(bit, 2) #converti le tout en decimal 
    return(nb) #renvoi la valeur en decimal

#lisez one piece 