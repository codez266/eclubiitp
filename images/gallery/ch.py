#import os
path = "C:\\\Users\\Saswat Raj\\Desktop\\e-club\\gallery"
#i = 0
#for f in os.listdir(path):
#    os.rename(f,"gal"+str(i)+".jpg")
#    i = i + 1
from PIL import Image
import os
size = 255, 255
i = 0
for f in os.listdir(path):
    if i==0:
        i+=1
        continue
    num = f[3:]
    im = Image.open(f)
    im.thumbnail(size, Image.ANTIALIAS)
    im.save("th"+num)
    i+=1
    
    
