import csv

#class permettant de stocker les infos du .rep 

class test:
    def __init__(self, obsw, bds, tv, dte, nom): #création de la class 
        self.obsw = obsw
        self.bds = bds
        self.tv = tv
        self.dte = dte
        self.nom = nom

    def affiche(self): #fonction permettant d'afficher les valeurs 
        with open("trame.csv", "a") as fic:
            ecri = csv.writer(fic, delimiter = ";")
            ecri.writerow([self.obsw, self.bds, self.tv, self.dte, self.nom])

#class permettant de stocker les valeurs de l'entête de la trame 

class header:  #creation de la class 
    def __init__(self, date, b3, b5, size): #chaque valeur représente une valeur de l'entête 
        self.date = date
        self.b3 = b3
        self.b5 = b5
        self.size = size
    
    def affiche(self): #fonction permettant d'afficher la class
        
        with open("trame.csv", "a") as fic:
            ecri = csv.writer( fic, delimiter = ";")
            ecri.writerow([self.date, self.b3, self.b5, self.size])

#class permettant de stocker les valeurs du corps de la trame 

class body800: #creation de la class
    def __init__(self, tp, ms, md, f1, f2, f3, f4, f5, f6, ips, ipd, f9, f10, f11, f14, f16, f17, f18, f20, f21, f23, f25, f26, f27, f28, f29, f30, f32, f33, f34, f35):
        self.tp = tp
        self.ms = ms
        self.md = md
        self.f1 = f1
        self.f2 = f2
        self.f3 = f3
        self.f4 = f4
        self.f5 = f5
        self.f6 = f6
        self.ips = ips
        self.ipd = ipd
        self.f9 = f9
        self.f10 = f10
        self.f11 = f11
        self.f14 = f14
        self.f16 = f16
        self.f17 = f17
        self.f18 = f18
        self.f20 = f20
        self.f21 = f21
        self.f23 = f23
        self.f25 = f25
        self.f26 = f26
        self.f27 = f27
        self.f28 = f28
        self.f29 = f29
        self.f30 = f30
        self.f32 = f32
        self.f33 = f33
        self.f34 = f34
        self.f35 = f35

    def affiche(self): #fonction permettant d'afficher la class
       
        with open("trame.csv", "a") as fic:
            ecri = csv.writer( fic, delimiter = ";")
            ecri.writerow([f"type:{self.tp}",f"MAC SOURCE:{self.ms}",f"MAC DEST:{self.md}", f"f1: {self.f1}",f"f2 {self.f2}",f"f3 {self.f3}",f"f4 {self.f4}",f"f5 {self.f5}",f"f6 {self.f6}",f"ip source {self.ips}",f"ip dest {self.ipd}",f"f14 {self.f14}",f"f16 {self.f16}",f"f17 {self.f17}",  f"f18 {self.f18}",  f"f20 {self.f20}",  f"f21 {self.f21}", f"f23 {self.f23}", f"25 {self.f25}", f"f26 {self.f26}", f"f27 {self.f27}", f"f28 {self.f28}", f"f29 {self.f29}", f"f30 {self.f30}", f"f32 {self.f32}", f"f33 {self.f33}", f"f34 {self.f34}", f"f35 {self.f35}"])

class body806: #creation de la class
    def __init__(self, tp, ms, md, f1, f2, f3, f4, f5, f6, msd, ipsd, mtg, iptg):
        self.tp = tp
        self.ms = ms
        self.md = md
        self.f1 = f1
        self.f2 = f2
        self.f3 = f3
        self.f4 = f4
        self.f5 = f5
        self.f6 = f6
        self.msd = msd
        self.ipsd = ipsd
        self.mtg = mtg
        self.iptg = iptg


    def affiche(self): #fonction permettant d'afficher la class
        with open("trame.csv", "a") as fic:
            ecri = csv.writer( fic, delimiter = ";")
            ecri.writerow([f"type:{self.tp}",f"MAC SOURCE:{self.ms}",f"MAC DEST:{self.md}", f"f1: {self.f1}",f"f2 {self.f2}",f"f3 {self.f3}",f"f4 {self.f4}",f"f5 {self.f5}",f"f6 {self.f6}",f"mac sender {self.msd}",f"ip sender {self.ipsd}",f"mac target {self.mtg}",f"ip target {self.iptg}"])
            
            
            
            
            
#print(f"date {self.date}, b3 {self.b3}, b5 {self.b5}, taille {self.size}")
# print(f"MAC source {self.ms},\n MAC dest {self.md},\n f1 {self.f1},\n f2 {self.f2},\n f3 {self.f3},\n f4 {self.f4},\n f5 {self.f5},\n f6 {self.f6},\n ip source {self.ips},\n ip dest {self.ipd},\n f14 {self.f14},\n f16 {self.f16},\n f17 {self.f17},\n f18 {self.f18},\n f20 {self.f20},\n f21 {self.f21},\nf23 {self.f23},\nf25 {self.f25},\nf26 {self.f26},\nf27 {self.f27},\nf28 {self.f28},\nf29 {self.f29},\nf30 {self.f30},\nf32 {self.f32},\nf33 {self.f33},\nf34 {self.f34},\nf35 {self.f35}")