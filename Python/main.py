import cl_trame  #import du fichier qui creer les classes 
from fonction import *     #import du fichier avec toutes les fonctions






if __name__ == '__main__':      #programme principal

    dt = read_convert(8, 16)       
    b3 = read_convert(16, 20) ### !!!!!!!! NE MARCHE PAS A MODIFIER en gros le prog va cherche du 16 au 20 eme octet or on veut juste les bits 13 a 16 de cet octet
    b5 = read_convert(20, 24)
    fz = read_convert(24, 28)
    T1 = cl_trame.header(dt, b3, b5, fz)
    T1.affiche() 
    ms = adr_MAC(read_MAC(28, 34))
    md = adr_MAC(read_MAC(34, 40)) # t'es super beau basile t'as repris bleach ? 