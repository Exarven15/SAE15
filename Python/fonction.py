import datetime
import pytz
import struct
import cl_trame
import json
 

def ouverture(fic): #fonction permetant de d'ouvrir le fichier binaire prend en entré le nom du fichier binaire 
    with open(fic, "rb") as f: #ouvre le fichier 
        global binary   #rend la varible global 
        binary = f.read() #met dans la variable le contenu de mon fichier
    with open("FT/FT_7.json", "r") as fic:
        global FT_7
        FT_7 = json.load(fic)
    with open("FT/FT_6.json", "r") as fic:
        global FT_6
        FT_6 = json.load(fic)
    with open("FT/FT_5.json", "r") as fic:
        global FT_5
        FT_5 = json.load(fic)
    with open("FT/FT_4.json", "r") as fic:
        global FT_4
        FT_4 = json.load(fic)
    with open("FT/FT_3.json", "r") as fic:
        global FT_3
        FT_3 = json.load(fic)
    with open("FT/FT_2.json", "r") as fic:
        global FT_2
        FT_2 = json.load(fic)
    with open("FT/FT_1.json", "r") as fic:
        global FT_1
        FT_1 = json.load(fic)
    with open("FT/FT_0.json", "r") as fic:
        global FT_0
        FT_0 = json.load(fic)
    with open("FT/MAC_ADR.json", "r") as fic:
        global MAC_ADR
        MAC_ADR = json.load(fic)
    with open("FT/IP_ADR.json", "r") as fic:
        global IP_ADR
        IP_ADR = json.load(fic)    

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
    # Ajoute le nombre de secondes à partir du 01/01/2000 à 12h00:00
    date_2000 = datetime.datetime(2000, 1, 1, 12, 0, 0)
    date = date_2000 + datetime.timedelta(seconds=nb)
    
    # Convertit la date en UTC
    timezone = pytz.timezone('Europe/Paris')
    date_utc = timezone.localize(date).astimezone(pytz.utc)
    
    # Formate la date
    date_format = date_utc.strftime('%d/%m/%Y %H:%M:%S.%f')
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
    return(ip) #renvoi l'adr ip

#fonction permettant de lire les octets bits par bits 

def read_bytes(octd, octf, bitd, bitf): #prend en entre l'octet de depart -1 et l'octet de fin et le bits de depart -1 et le bits de fin
    n = octf - octd #calcule ne nombre d'octet demandé
    nb = read_convert(octd, octf) #cherche la valeur en decimal des octets 
    nb_bin = str(bin(nb))[2:] #converti l'octet en binaire et le met enleve le 0b devant
    nb_bin = nb_bin.zfill(n*8) #remplis le nombre de bits necessaire par des 0 devants car enlevés au moment des converisons
    bit = nb_bin[bitd : bitf] # prends dans la chaine de charactère les octets demandés 
#    print(bit)
    nb = int(bit, 2) #converti le tout en decimal 
#    print(nb)
    return(nb) #renvoi la valeur en decimal

#fonction permettant de lire les données du .rep

def fichier(rep, cpter): #prend en entré le nom du fichier
    with open(rep, "rb") as fic:    #ouvre le fichier en binaire
        lines = fic.readlines() #lit chaque ligne 
        obsw1 = lines[7].decode().rstrip().split(": ")[1] #lit chaque ligne qui nous interesse 
        obsw2 = lines[8].decode().rstrip().split(": ")[1]
        obsw = obsw1 + " " +obsw2 #concataine les 2 valeurs de obsw
        bds = lines[9].decode().rstrip().split(": ")[1]
        tv = lines[10].decode().rstrip().split(": ")[1]
        dt = lines[14].decode().rstrip().replace('"', '').split(": ")[1] #enleve les guillemets pour gérer les pb en csv
        nom = lines[27].decode().rstrip().split(": ")[1]
    test = cl_trame.test(cpter, obsw, bds, tv, dt, nom)   #création de la variable pour stocker la class
    test.affiche() #utilisation de la fonction permettant de l'envoyer 

def fct_transfert(val, FT):
    if FT == "FT_0":
        for brut in FT_0:
            if val == brut:
                label = FT_0[brut] #[val]
                return(label)
        return(int(val, base=16))

    if FT == "FT_1":
        for brut in FT_1:
            if val == brut:
                label = FT_1[brut]
                return(label)
        return(int(val, base=16))

    if FT == "FT_2":
        for brut in FT_2:
            if val == brut:
                label = FT_2[brut]
                return(label)
        return(int(val, base=16))

    if FT == "FT_3":
        for brut in FT_3:
            if val == brut:
                label = FT_3[brut]
                return(label)
        return(int(val, base=16))

    if FT == "FT_4":
        for brut in FT_4:
            if val == brut:
                label = FT_4[brut]
                return(label)
        return(int(val, base=16))

    if FT == "FT_5":
        for brut in FT_5:
            if val == brut:
                label = FT_5[brut]
                return(label)
        return(int(val, base=16))
    
    if FT == "FT_6":
        for brut in FT_6:
            if val == brut:
                label = FT_6[brut]
                return(label)
        return(False)
            
    if FT == "FT_7":
        for brut in FT_7:
            if val == brut:
                label = FT_7[brut]
                return(label)
        return(int(val, base=16))

def useft(octd, octf,  FT, bd=0, bf=0):
    if  FT != "FT_5" and FT != "FT_1":
        value = "0x"+str(read_bytes(octd, octf, bd, bf)).zfill(2)
        return(fct_transfert(value, FT))
    elif FT == "FT_5":
        value = str(int(read_bytes(octd, octf, bd, bf)))
        return(fct_transfert(value, FT))
    else:
        value = str(read_convert(octd, octf))
        return(fct_transfert(value, FT))

def ft_adr(tp, adr):
    if tp == "MAC":
        for brut in MAC_ADR:
            if adr == brut:
                label = MAC_ADR[brut]
                return(label)
        return(adr)
    elif tp == "IP":
        for brut in IP_ADR:
            if adr == brut:
                label = IP_ADR[brut]
                return(label)
        return(adr)

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

if __name__ == '__main__':

    ouverture("../test/test2/ethernet.result_data")
    #print(made_cpter())
    print(ft_adr("MAC", read_MAC(28, 34)))

#lisez one piece 