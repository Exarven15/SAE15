import click

@click.command(help='Programme prennant en entrée deux programmes')
@click.option("--file1", help="chemin vers le fichier binaire")
@click.option("--file2", help="chemin vers le fichier de configuration")

def feur(file1, file2):
    print(file1)
    print(file2)

def verifbin(link):
    ext = link.split(".")
    if ext[-1] != "result_data":
        return False
    
def verifrep(link):
    ext = link.split(".")
    if ext[-1] != "rep":
        return False 
    
def test(bine, rep):
    if verifbin(bine) == False or verifrep(rep) == False:
        return("Erreur")
    else:
        print("ok")

print(test("ethernet.result_data","Vt_DEMO_power_on.rep"))