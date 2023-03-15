#class permettant de stocker les valeurs de l'entête de la trame 

class header:  #creation de la class 
    def __init__(self, date, b3, b5, size): #chaque valeur représente une valeur de l'entête 
        self.date = date
        self.b3 = b3
        self.b5 = b5
        self.size = size
    
    def affiche(self): #fonction permettant d'afficher la class
        print(f"date {self.date}, b3 {self.b3}, b5 {self.b5}, taille {self.size}")

#class permettant de stocker les valeurs du corps de la trame 

class body: #creation de la class
    def __init__(self, ms, md, f1, f2, f3, f4, f5, f6, ips, ipd): #pas terminé car pas sur de necessaire 
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
    