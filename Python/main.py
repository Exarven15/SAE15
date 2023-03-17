import cl_trame  #import du fichier qui creer les classes 
from fonction import *     #import du fichier avec toutes les fonctions
import time


def main():
    cpttrame = 1
    cptoctet = 0
    state = True
    while state == True:
        dt = read_date(cptoctet+8,cptoctet+16)       
        b3 = read_convert(cptoctet+16,cptoctet+20) 
        b5 = read_bytes(cptoctet+20, cptoctet+24, 12, 16) 
        fz = read_convert(cptoctet+24, cptoctet+28)
        globals()["T{}".format(cpttrame)] = cl_trame.header(dt, b3, b5, fz)
        globals()["T{}".format(cpttrame)].affiche()
        ms = read_MAC(cptoctet+28, cptoctet+34)
        md = read_MAC(cptoctet+34, cptoctet+40)
        f1 = read_convert(cptoctet+40, cptoctet+42)
        f2 = read_convert(cptoctet+42, cptoctet+44)
        f3 = read_convert(cptoctet+44, cptoctet+46)
        f4 = read_convert(cptoctet+46, cptoctet+48)
        f5 = read_convert(cptoctet+48, cptoctet+50)
        f6 = read_convert(cptoctet+50, cptoctet+51)
        ips = adr_ip(cptoctet+54, cptoctet+58)
        ipd = adr_ip(cptoctet+58, cptoctet+62)
        f9 = read_convert(cptoctet+62, cptoctet+64)
        f10 = read_convert(cptoctet+64, cptoctet+66)
        f11 = read_convert(cptoctet+66, cptoctet+68)
        f14 = read_bytes(cptoctet+70, cptoctet+72, 3, 4)
        f16 = read_bytes(cptoctet+70, cptoctet+72, 5, 8)
        f17 = read_bytes(cptoctet+70, cptoctet+72, 8, 11)
        f18 = read_bytes(cptoctet+70, cptoctet+72, 11, 16)
        f20 = read_bytes(cptoctet+72, cptoctet+74, 1, 16)
        f21 = read_convert(cptoctet+74, cptoctet+76)
        f23 = read_bytes(cptoctet+76, cptoctet+77, 4, 5) 
        f25 = read_bytes(cptoctet+76, cptoctet+77, 6, 7)
        f26 = read_bytes(cptoctet+76, cptoctet+77, 7, 8)
        f27 = read_bytes(cptoctet+77, cptoctet+78, 0, 2)
        f28 = read_bytes(cptoctet+77, cptoctet+78, 2, 8)
        f29 = read_bytes(cptoctet+78, cptoctet+80, 0, 6)
        f30 = read_bytes(cptoctet+78, cptoctet+80, 6, 16)
        f32 = read_convert(cptoctet+81, cptoctet+82)
        f33 = read_convert(cptoctet+82, cptoctet+84)
        f34 = read_convert(cptoctet+84, cptoctet+86)
        f35 = read_convert(cptoctet+86, cptoctet+88)
        globals()["B{}".format(cpttrame)] = cl_trame.body(ms, md, f1, f2, f3, f4, f5, f6, ips, ipd, f9, f10, f11, f14, f16, f17, f18, f20, f21, f23, f25, f26, f27, f28, f29, f30, f32, f33, f34, f35)
        globals()["B{}".format(cpttrame)].affiche()
        cptoctet = cptoctet + fz + 28
        cpttrame = cpttrame +1
        if not read_convert(cptoctet, cptoctet+8):
            state = False
        
main()

# t'es super beau basile t'as repris bleach ?