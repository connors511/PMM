function cLog(txt) {
    if(!(typeof console === 'undefined')) {
        console.log(txt);
    }
}

String.prototype.visualLength = function()
{
    var ruler = document.getElementById("ruler").getElementsByTagName('div')[0];
    document.getElementById("ruler").style.display = 'block';
    ruler.innerHTML = this;
    var width = ruler.offsetWidth;
    document.getElementById("ruler").style.display = 'none';
    return width;
}
 
String.prototype.trimToPx = function(length)
{
    var tmp = this;
    var trimmed = this;
    if (tmp.visualLength() > length)
    {
        trimmed += "...";
        while (trimmed.visualLength() > length)
        {
            tmp = tmp.substring(0, tmp.length-1);
            trimmed = tmp + "...";
        }
    }
     
    return trimmed;
}