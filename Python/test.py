import click

@click.command()
@click.argument("name")
@click.option("--dt", type=click.DateTime(formats=["%d-%m-%Y-%H:%M:%S"]), nargs=1)
@click.option("--a")
def main(name,dt,a):
    """
    Test
    """
    if dt== None:
        print("Syntaxe = 'python main.py [FICHIER BIN] --rep --options' \n Si --rep n'est pas donné, --dt est obligatoire \n Pour obtenir de l'aide voir, 'python main.py --help'")
        exit()
    print(f'Hello {name}')
    if a:
        print(a)
    print(dt)
if __name__ == "__main__":
    main()