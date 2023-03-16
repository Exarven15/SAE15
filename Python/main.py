import cl_trame  #import du fichier qui creer les classes 
from fonction import *     #import du fichier avec toutes les fonctions


print(date(read_binary(8, 16)))


if __name__ == '__main__':      #programme principal

    dt = read_date(8, 16)       
    b3 = read_convert(16, 20) ### !!!!!!!! NE MARCHE PAS A MODIFIER en gros le prog va cherche du 16 au 20 eme octet or on veut juste les bits 13 a 16 de cet octet
    b5 = read_convert(20, 24)
    fz = read_convert(24, 28)
    T1 = cl_trame.header(dt, b3, b5, fz)
    T1.affiche()
    ms = read_MAC(28, 34)
    md = read_MAC(34, 40)
    f1 = read_convert(40, 42)
    f2 = read_convert(42, 44)
    f3 = read_convert(44, 46)
    f4 = read_convert(46, 48)
    f5 = read_convert(48, 50)
    f6 = read_convert(50, 51)
    ips = adr_ip(54, 58)
    ipd = adr_ip(58, 62)
    f9 = read_convert(62, 64)
    f10 = read_convert(64, 66)
    f11 = read_convert(66, 68)
    B1 = cl_trame.body(ms, md, f1, f2, f3, f4, f5, f6, ips, ipd, f9, f10, f11)
    B1.affiche()


 # t'es super beau basile t'as repris bleach ?