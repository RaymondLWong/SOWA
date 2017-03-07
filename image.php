<script>
    function search() {
        let name = document.getElementById('search').value;
        document.getElementById('imageResult').innerHTML = '<img src="images/' + name + '.png" alt="desc" width="300">';
    }
</script>

<label for="search">Search an image by its ID.</label>
<input type="text" name="search" id="search" value=""/>
<input type="submit" name="submit" value="Search" onclick="search()">

<div id="imageResult"></div>