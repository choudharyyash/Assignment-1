#!/bin/bash
mkdir reqfil
for i in  $(seq 1 $1);
do
	cp /images/dog$i.jpg /reqfil/dog$i.jpg
done
for i in  $(seq 1 $2);
do
	cp /images/catt$i.jpg /reqfil/catt$i.jpg
done
for i in  $(seq 1 $3);
do
	cp /images/car$i.jpg /reqfil/car$i.jpg
done
for i in  $(seq 1 $4);
do
	cp /images/truck$i.jpg /reqfil/truck$i.jpg
done
 cd reqfil
zip -r final.zip .
cd ..

mv /reqfil/final.zip $(pwd)


#rmdir reqfil
