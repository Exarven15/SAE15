import cl_trame  #import du fichier qui creer les classes 
from fonction import *     #import du fichier avec toutes les fonctions

def main(bin, rep):
    ouverture(bin)
    fichier(rep)
    cpttrame = 1
    coct = 0
    state = True
    while state == True:
        dt = read_date(coct+8,coct+16)       
        b3 = read_convert(coct+16,coct+20)
        b5 = useft(coct+20, coct+24, "FT_0", 13, 16) #bytes
        fz = read_convert(coct+24, coct+28)
        if hex(read_convert(coct+40, coct+42))[2:] == "800":
            md = read_MAC(coct+28, coct+34)
            ms = read_MAC(coct+34, coct+40)
            f1 = hex(read_convert(coct+40, coct+42))[2:]
            f2 = read_convert(coct+42, coct+44)
            f3 = read_convert(coct+44, coct+46)
            f4 = read_convert(coct+46, coct+48)
            f5 = read_convert(coct+48, coct+50)
            f6 = read_convert(coct+50, coct+51)
            f7 = read_convert(coct+51, coct+52)
            ips = adr_ip(coct+54, coct+58)
            ipd = adr_ip(coct+58, coct+62)
            f9 = read_convert(coct+62, coct+64)
            f10 = read_convert(coct+64, coct+66)
            f11 = read_convert(coct+66, coct+68)
            f14 = useft(coct+70, coct+72, "FT_7", 3, 4) #bytes
            f16 = read_bytes(coct+70, coct+72, 5, 8)
            f17 = useft(coct+70, coct+72, "FT_5", 8, 11) #bytes deci
            f18 = useft(coct+70, coct+72, "FT_2", 11, 16) #bytes
            f20 = read_bytes(coct+72, coct+74, 1, 16)
            f21 = read_convert(coct+74, coct+76)
            f23 = read_bytes(coct+76, coct+77, 4, 5) 
            f25 = read_bytes(coct+76, coct+77, 6, 7)
            f26 = read_bytes(coct+76, coct+77, 7, 8)
            #f27 = read_bytes(coct+77, coct+78, 0, 2)
            f28 = useft(coct+77, coct+78, "FT_3", 2, 8) #bytes hexa
            f29 = useft(coct+78, coct+80, "FT_4", 0, 6) #bytes hexa
            f30 = read_bytes(coct+78, coct+80, 6, 16)
            f32 = useft(coct+81, coct+82, "FT_1") #octet deci
            f33 = read_convert(coct+82, coct+84)
            f34 = read_convert(coct+84, coct+86)
            f35 = read_convert(coct+86, coct+88)
            #if coct == 0:
            #    print(f33+f34, f35/2**16)
            globals()["B{}".format(cpttrame)] = cl_trame.body800(dt, b3, b5, fz, ms, md, f1, f2, f3, f4, f5, f6, f7, ips, ipd, f9, f10, f11, f14, f16, f17, f18, f20, f21, f23, f25, f26, f28, f29, f30, f32, f33)
            globals()["B{}".format(cpttrame)].affiche()
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
            globals()["B{}".format(cpttrame)] = cl_trame.body806(dt, b3, b5, fz, ms, md, f1, f2, f3, f4, f5, f6, msd, ipsd, mtg, iptg)
            globals()["B{}".format(cpttrame)].affiche()
            coct = coct + fz + 28
            cpttrame = cpttrame +1

        if not read_convert(coct, coct+8):
            state = False
        
main("/var/www/Projet/Python/ethernet.result_data_", "/var/www/Projet/Python/Vt_DEMO_power_on.rep")


