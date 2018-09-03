rm *.jpg *.html
unzip a1.zip
 rm *.zip

a='<html>
<head>

<style>
.container{
    border: 1px solid #ccc;
    text-align: center;
}
.category{
    display: inline-block;
    width: 100px;
    height: 100px;
    background: #ccc;
    margin: 5px;
}
</style>
</head>


<body>


<div class="container">'
echo "$a" >> web.html

find -name "dog*.***" >> out.txt
echo "<br>" >> out.txt
find -name "catt*.***" >> out.txt
echo "<br>" >> out.txt
find -name "car*.***" >> out.txt
echo "<br>" >> out.txt
find -name "truck*.***" >> out.txt

sed -E '/(br)/!s/^/ <img src= /' out.txt > a.txt
sed -E '/(br)/!s/.*/&>/' a.txt >> web.html

b='</div>
</body>
</html>'
echo "$b" >> web.html
rm *.txt 
xdg-open web.html

