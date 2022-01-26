<# if ( data.value == "1" ) { #>
    <label for="showheader"><input type="checkbox" id="showheader" name="{{data.name}}" value="1" checked /></label>
  <# } else { #>
    <label for="showheader"><input type="checkbox" id="showheader" name="{{data.name}}" value="1" /></label>
<# } #>