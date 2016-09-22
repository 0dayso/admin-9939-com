<form action="/jbzz/" method="get" class="frmly <?php echo isset($class) ? $class : ''; ?>">
    <input type="search" name="key" id="key" value="" placeholder="请输入疾病名、症状名" >
    <input type="submit" value=" " onclick="return soso();">
</form>
<!--<div class="thre"></div>-->

<script>
    function soso(){
        var key = document.getElementById('key').value;
        if(key==""){
            return false;
        }
    }
</script>