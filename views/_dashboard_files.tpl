<span class="small">Show Only: <span class="smlink" onClick="update_files('all', 'files');">All</span> | <span class="smlink" onClick="update_files('new', 'files');">New</span> | <span class="smlink" onClick="update_files('mod', 'files');">Modified</span> | <span class="smlink" onClick="update_files('del', 'files');">Deleted</span></span><br>
<?php include("views/_list_files.tpl"); ?>
<span class="small">Available Actions: <SELECT ID="git-action" NAME="git-action" class="small"><option default></option><OPTION VALUE="">Analyze</OPTION><OPTION VALUE="">Commit</OPTION><OPTION VALUE="">Rollback</OPTION><OPTION VALUE="">Stage</OPTION></select>
 Key: <span class="green">New File</span> <span class="orange">Modified</span> <span class="red">Deleted</span></span>
