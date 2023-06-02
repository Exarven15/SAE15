import mysql.connector 
from fonction import *     #import du fichier avec toutes les fonctions
import time

connection_params = {
    'host': "localhost",
    'user': "root",
    'password': "root",
    'database': "base",
    'auth_plugin': 'mysql_native_password'
}

def main(bine, rep):
    db = mysql.connector.connect(**connection_params)
    cursor = db.cursor()
    FT = (ouverture(bine))
    cpter = made_cpter()
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
    db.commit()
    cpttrame = 1
    coct = 0
    state = True
    while state == True:
        dt = read_date(coct+8,coct+16)
        b3 = read_convert(coct+16,coct+20)
        b5 = useft(coct+20, coct+24, "FT_0", 13, 16) #bytes
        fz = read_convert(coct+24, coct+28)
        if hex(read_convert(coct+40, coct+42))[2:] == "800":
            md = fct_transfert(read_MAC(coct+28, coct+34), FT.get("MAC_ADR"))
            ms = fct_transfert(read_MAC(coct+34, coct+40), FT.get("MAC_ADR"))
            f1 = hex(read_convert(coct+40, coct+42))[2:]
            f2 = read_convert(coct+42, coct+44)
            f3 = read_convert(coct+44, coct+46)
            f4 = read_convert(coct+46, coct+48)
            f5 = read_convert(coct+48, coct+50)
            f6 = read_convert(coct+50, coct+51)
            f7 = read_convert(coct+51, coct+52)
            ips = fct_transfert(adr_ip(coct+54, coct+58), FT.get("IP_ADR"))
            ipd = fct_transfert(adr_ip(coct+58, coct+62), FT.get("IP_ADR"))
            f9 = read_convert(coct+62, coct+64)
            f10 = read_convert(coct+64, coct+66)
            f11 = read_convert(coct+66, coct+68)
            ft14 = useft(coct+70, coct+72, "FT_7", 3, 4) #bytes
            f14 = read_bytes(70, 72, 3, 4)
            f16 = read_bytes(coct+70, coct+72, 5, 8)
            f17 = useft(coct+70, coct+72, "FT_5", 8, 11) #bytes deci
            ft18 = useft(coct+70, coct+72, "FT_2", 11, 16) #bytes
            f18 = read_bytes(70, 72, 11, 16)
            f20 = read_bytes(coct+72, coct+74, 1, 16)
            f21 = read_convert(coct+74, coct+76)
            f23 = read_bytes(coct+76, coct+77, 4, 5) 
            f25 = read_bytes(coct+76, coct+77, 6, 7)
            f26 = read_bytes(coct+76, coct+77, 7, 8)
            ft28 = useft(coct+77, coct+78, "FT_3", 2, 8) #bytes hexa
            f28 = read_bytes(77, 78, 2, 8)
            ft29 = useft(coct+78, coct+80, "FT_4", 0, 6) #bytes hexa
            f29 = read_bytes(78, 80, 0, 6)
            f30 = read_bytes(coct+78, coct+80, 6, 16)
            f32 = useft(coct+81, coct+82, "FT_1") #useft(coct+81, coct+82, "FT_1") octet deci
            f33 = read_convert(coct+82, coct+86)
            f35 = read_convert(coct+86, coct+88)
            pkdt = date_2000(f33+f35/2**16)
            ft_6 = fct_transfert(FT6(f14, f18, f28, f29, f30), FT.get("FT_6"))
            request = """insert into trames 
            (idFichier,dteT, b3, b5, size, macDest, macSource, f1, f2, f3, f4, f5, f6, f7,  macSender, ipSender, macTarget, ipTarget, ipSource, ipDest, f9, f10, f11, f14, f16, f17, f18, f20, f21, f23, f25, f26, f28, f29, f30, f32, pkDte, ft_6)
            values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
            params =(cpter, dt, b3, b5, fz, md, ms, f1, f2, f3, f4, f5, f6, f7, "", "", "", "",ips, ipd, f9, f10, f11, ft14, f16, f17, ft18,  f20, f21, f23, f25, f26, ft28, ft29, f30, f32, pkdt, ft_6)
            cursor.execute(request, params)
            db.commit()
            coct = coct + fz + 28
            cpttrame = cpttrame +1
        else:
            ms = read_MAC(coct+28, coct+34)
            md = read_MAC(coct+34, coct+40)
            f1 = hex(read_convert(coct+40, coct+42))[2:]
            f2 = read_convert(coct+42, coct+44)
            f3 = read_convert(coct+44, coct+46)
            f4 = read_convert(coct+46, coct+47)
            f5 = read_convert(coct+47, coct+48)
            f6 = read_convert(coct+48, coct+50)
            msd = read_MAC(coct+50, coct+56)
            ipsd = adr_ip(coct+56, coct+60)
            mtg = read_MAC(coct+60, coct+66)
            iptg = adr_ip(coct+66, coct+70)
            request = """insert into trames 
            (idFichier, dteT, b3, b5, size, macDest, macSource, f1, f2, f3, f4, f5, f6, f7, macSender, ipSender, macTarget, ipTarget, ipSource, ipDest, f9, f10, f11, f14, f16, f17, f18, f20, f21, f23, f25, f26, f28, f29, f30, f32, pkDte)
            values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
            params =(cpter, dt, b3, b5, fz, ms, md, f1, f2, f3, f4, f5, f6, "", msd, ipsd, mtg, iptg, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "")
            cursor.execute(request, params)
            db.commit()
            coct = coct + fz + 28
            cpttrame = cpttrame +1

        if not read_convert(coct, coct+8):
            state = False
    db.disconnect()

deb = time.time()
main("../test/test2/ethernet.result_data", "../test/test2/Vt_DEMO_mem_observability.rep") #Vt_DEMO_mem_observability   Vt_DEMO_power_on
print(time.time() - deb)
