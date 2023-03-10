import struct

def read_binary(octd, octf):
    with open("ethernet.result_data_", "rb") as fic:
        binary = fic.read()
        return (binary[octd: octf])

def convert_deci(nb):
    dec_number = struct.unpack('>i', nb)
    return (dec_number)

var = struct.unpack('>i', read_binary(24, 28))
print(var)

print(convert_deci(read_binary(24, 28)))











































print("j'aime les bites comme alban")