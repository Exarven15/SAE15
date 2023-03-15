import datetime
import struct

#fonction permetant de chercher la valeur de la variable dans le fichier

def read_binary(octd, octf):  #prend en entreé la valeur en octet de but - 1 et la valeur en octet de fin             
    with open("ethernet.result_data_", "rb") as fic:    
        binary = fic.read()
        return (binary[octd: octf]) #renvoie un chiffre encodé 

#fonction permettant de décoder la valeur renvoyé donné par read_binary

def convert_deci(nb):  #prend en entré une valeur de read_binary
    dec_number = int.from_bytes(nb, byteorder='big', signed=False)
    return (dec_number) #renvoi une valeur en decimal 

#fonction permettant de lire et convertir 

def read_convert(octd, octf):
    return(convert_deci(read_binary(octd, octf)))

#fonction qui pemet de convertir frame date en utilisant le codage timestamp

def date(nb): #prend en entré une valeur de read_binary 
    nb = struct.unpack('>d', nb)[0] #utilise la fonction unpack de struct pour convertir le 
    date = datetime.datetime.fromtimestamp(nb)  #utilise la fonction 
    date_format = date.strftime('%d/%m/%Y %H:%M:%S')
    return(date_format) #renvoie la date au format jj/mm/aaaa ss/mm/hh

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
    return(adr_MAC(convert_deci(read_binary(octd, octf))))

#fonction permettant de convertir une valeur decimal en adr IP

def adr_ip(nb):  #programe non fonctionel pas encore terminé 
    nb = str(nb)
    list_ip = []
    for i in range (1,5):
        ip = nb[i : i+1]
        ip = convert_deci(ip)
        list_ip.append(str(ip))
    nb = ".".join(list_ip)
    return(nb)

