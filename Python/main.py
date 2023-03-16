import cl_trame  #import du fichier qui creer les classes 
from fonction import *     #import du fichier avec toutes les fonctions



if __name__ == '__main__':      #programme principal

    dt = read_date(8, 16)       
    b3 = read_convert(16, 20) 
    b5 = read_bytes(20, 24, 12, 16) 
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
    f14 = read_bytes(70, 72, 3, 4)
    f16 = read_bytes(70, 72, 5, 8)
    f17 = read_bytes(70, 72, 8, 11)
    f18 = read_bytes(70, 72, 11, 16)
    f20 = read_bytes(72, 74, 1, 16)
    f21 = read_convert(74, 76)
    f23 = read_bytes(76, 77, 4, 5) 
    f25 = read_bytes(76, 77, 6, 7)
    f26 = read_bytes(76, 77, 7, 8)
    f27 = read_bytes(77, 78, 0, 2)
    f28 = read_bytes(77, 78, 2, 8)
    f29 = read_bytes(78, 80, 0, 6)
    f30 = read_bytes(78, 80, 6, 16)
    f32 = read_convert(81, 82)
    f33 = read_convert(82, 84)
    f34 = read_convert(84, 86)
    f35 = read_convert(86, 88)
    B1 = cl_trame.body(ms, md, f1, f2, f3, f4, f5, f6, ips, ipd, f9, f10, f11, f14, f16, f17, f18, f20, f21, f23, f25, f26, f27, f28, f29, f30, f32, f33, f34, f35)
    B1.affiche()

# t'es super beau basile t'as repris bleach ?