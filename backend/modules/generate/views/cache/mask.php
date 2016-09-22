<style>
.black_overlay{
display: none;
position: absolute;
top: 0%;
left: 0%;
width: 100%;
height: 100%;
background-color: black;
z-index:1001;
-moz-opacity: 0.8;
opacity:.80;
filter: alpha(opacity=80);
}
.white_content {
display: none;
position: absolute;
top: 30%;
left: 30%;
width: 40%;
height: 30%;
border: 6px solid #009967;
background-color: white;
z-index:1002;
overflow: auto;
}
</style>

<div id="mask" class="black_overlay">
</div>

<div id="popup" class="white_content">
<h1>正在生成缓存，请稍后……</h1>
</div>