<!--

<head>
   <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
  <script type='text/javascript' src='/lib/ace/ace.js' charset='utf-8'></script>
</head>

<body>

  <div id="code-editor">
  </div>

</body>


<script type="text/javascript">
  var editor = ace.edit("code-editor");
  editor.setTheme("ace/theme/xcode");
  editor.getSession().setMode("ace/mode/c_cpp");
</script>

-->


<!DOCTYPE html>
<html lang="en">
<head>
<title>ACE in Action</title>
<style type="text/css" media="screen">
    #editor { 
       width:300px;
       height:600px;

 

    }
</style>
</head>
<body>

<div id="editor">function foo(items) {
    var x = "All this is syntax highlighted";
    return x;
}</div>
    
<script src="/lib/ace/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/xcode");
    editor.getSession().setMode("ace/mode/c_cpp");
</script>
</body>
</html>
