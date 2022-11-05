<html lang="en">
<head>
  <title>Listless</title>
  <!--Javascript libraries and corresponding styles-->
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
  <!-- Popper before bootstrap-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
  <!-- Bootstrap -->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
  <!-- Optional theme -->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"/>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <!-- Datatables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css"/>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js" crossorigin="anonymous"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" crossorigin="anonymous"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js" crossorigin="anonymous"></script>
  <!--Toastr-->
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <!--Material Icons-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!--Make it display big on a phone-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style type="text/css">
  .material-switch > input[type="checkbox"] {
    display: none;
  }

  .material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative;
    width: 40px;
  }

  .material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
  }
  .material-switch > label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
  }
  .material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
  }
  .material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit;
    left: 20px;
  }
</style>
</head>
<body>
  <h1>Listless</h1>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" onclick="loadCategories()" data-toggle="modal" data-target="#newItemModal" rel="tooltip" data-placement="bottom" title="add item" data-animation="true"><i class="material-icons">add</i></button>
  <button type="button" class="btn btn-primary" onclick="removeTicked()" rel="tooltip" data-placement="bottom" title="remove ticked" data-animation="true"><i class="material-icons">delete_sweep</i></button>
  <button type="button" class="btn btn-primary" onclick="undoRemoved()" rel="tooltip" data-placement="bottom" title="undo remove" data-animation="true"><i class="material-icons">undo</i></button>
  <div class="material-switch pull-right" rel="tooltip" title="Auto clear">
    <input id="autoClearSelect" name="autoClear" type="checkbox"/>
    <label for="autoClearSelect" class="label-primary">Autoclear</label>
  </div>
  <table class="table-responsive table-striped table-bordered table-condensed" id="tableID"></table>
</div>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newCategoryModal" rel="tooltip" data-placement="bottom" title="add category" data-animation="true"><i class="material-icons">speaker_notes</i></button>
<button type="button" class="btn btn-primary" onclick="selRemoveCategory()" data-toggle="modal" data-target="#delCategoryModal" rel="tooltip" data-placement="bottom" title="delete category" data-animation="true"><i class="material-icons">speaker_notes_off</i></button>
<div class="material-switch pull-right" rel="tooltip" title="Edit">
  <input id="editModeSelect" name="editMode" type="checkbox"/>
  <label for="editModeSelect" class="label-primary">editMode</label>
</div>
<!-- Modal -->
<div class="modal fade" id="newItemModal" tabindex="-1" role="dialog" aria-labelledby="newItemModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newItemModalLabel">Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="inputItem">New Item</label>
          <input type="item" class="form-control" id="inputItem" aria-describedby="itemInput" placeholder="Item">
        </div>
        <div class="form-group">
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              Category
              <span class="caret"></span>
            </button>
            <!--we will dynamically load this from a table-->
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="newItem()" class="btn btn-primary" rel="tooltip" data-placement="bottom" title="save changes" data-animation="true"><i class="material-icons">save</i></button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editItemModalLabel">Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="editItem">Edit Item</label>
          <input type="item" class="form-control" id="editItem" aria-describedby="editInput" placeholder="Item">
        </div>
        <div class="form-group">
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              Category
              <span class="caret"></span>
            </button>
            <!--we will dynamically load this from a table-->
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu3" id="drop3">
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="editItem()" class="btn btn-primary" rel="tooltip" data-placement="bottom" title="save changes" data-animation="true"><i class="material-icons">save</i></button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delCategoryModal" tabindex="-1" role="dialog" aria-labelledby="delCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delCategoryModalLabel">Delete Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              Category
              <span class="caret"></span>
            </button>
            <!--we will dynamically load this from a table-->
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2" id="drop2">
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="removeCategory()" class="btn btn-primary" rel="tooltip" data-placement="bottom" title="remove category" data-animation="true"><i class="material-icons">save</i></button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="newCategoryModal" tabindex="-1" role="dialog" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newCategoryModal">Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="inputItem">New Category</label>
          <input type="item" class="form-control" id="inputCategory" aria-describedby="categoryInput" placeholder="Category">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="newCategory()" class="btn btn-primary" rel="tooltip" data-placement="bottom" title="add category"><i class="material-icons">save</i></button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script>
//vars
var listtable;
var selid;
//lightly browned toastr
toastr.options = {
  timeOut: 5
};
//get teh categories - not implemented on this page yet but the controller has a function
function loadCategories(){
  $.ajax({
    url: './functions.php',
    type: 'get',
    contentType: "application/json",
    dataType: 'json',
    data: {action:'getcategory'},
    success: function(data) {
      //called when successful
      //clear the dropdown in case you just added one
      document.querySelector('.dropdown-menu').innerHTML=''
      $.each(data, function(idx, cat){
        //I have a name to insert in the dropdown for each
        //each element has a unique id
        document.querySelector('.dropdown-menu').innerHTML+='<li><a href="#" id="'+idx+'">'+cat+'</a></li>'
      })
      $(".dropdown-menu li a ").click(function(){
        $("#dropdownMenu1:first-child").text($(this).text());
        $("#dropdownMenu1:first-child").val($(this).text());
      });
    }
  })
}

function selRemoveCategory(){
  $.ajax({
    url: './functions.php',
    type: 'get',
    contentType: "application/json",
    dataType: 'json',
    data: {action:'getcategory'},
    success: function(data) {
      //called when successful
      //clear the dropdown in case you just removed one
      document.querySelector('#drop2').innerHTML=''
      $.each(data, function(idx, cat){
        //referring to this by id for variety
        document.querySelector('#drop2').innerHTML+='<li><a href="#" id="'+idx+'">'+cat+'</a></li>'
      })
      $("#drop2 li a ").click(function(){
        $("#dropdownMenu2:first-child").text($(this).text());
        $("#dropdownMenu2:first-child").val($(this).text());
      });
    }
  })
}

function removeCategory(){
  $.get("./functions.php",{action:'deletecategory', category:$('#dropdownMenu2').val()},function(){
    $("#dropdownMenu2:first-child").text('Category');
    //in case you delete the current selected for add lets us clear it
    $("#dropdownMenu1:first-child").text('Category');
    $('#delCategoryModal').modal('hide');
    toastr.success("removed");
  });
}

function removeTicked(){
  $.get("./functions.php",{action:'removeticked'},function(){
    listtable.ajax.reload()
  });
  if($('#autoClearSelect').prop('checked')){
    toastr.success("autocleared")
  } else {
    toastr.success("cleared");
  }
}

function undoRemoved(){
  $.get("./functions.php",{action:'undoremove'},function(){
    listtable.ajax.reload()
  });
  toastr.success("undone");
}

//edit an item
function editItem(){
  //we have an edit function - needs idlist, line and category as a get
  $('#editItemModal').modal('hide')
  //get the line name is in the form and category if it changed
  var line=document.getElementById("editItem").value
  line=line.replace("'","''")
  var cat=$("#dropdownMenu3:first-child").text()
  //Now to save it and reload the table
  var updates={action:'edititem',idlist:selid[0],line:line,category:cat}
  console.log(updates)
  $.get("./functions.php",updates,function(){
    listtable.ajax.reload()
    toastr.success("Item updated")
  });
}

//Save new item
function newItem (){
  $('#newItemModal').modal('hide')
  if($('#dropdownMenu1').val()!='' && $('#inputItem').val()!=''){//don't want it saved without category or item
    var item=$('#inputItem').val()
    item=item.replace("'","''")
    var cat=$('#dropdownMenu1').val()
    cat=cat.replace("'","''")
    var saveitem = {action:'insertitem',item:item, category:cat};
    $.get("./functions.php",saveitem,datasaved);
    //console.log(saveitem)
  }
}

function newCategory (){
  $('#newCategoryModal').modal('hide')
  if($('#inputCategory').val()!=''){//don't want it saved without category
    var cat=$('#inputCategory').val()
    cat=cat.replace("'","''")
    var savecat = {action:'addcategory',category:cat};
    $.get("./functions.php",savecat,categorysaved);
    //console.log(savecat)
  }
}

function categorysaved(){
  //clear the modal form for next time
  document.getElementById("inputCategory").value=""
  //redraw the table
  listtable.ajax.reload()
  toastr.success("category added")
}

function datasaved (){
  //clear the modal form for next time
  document.getElementById("inputItem").value=""
  //redraw the table
  listtable.ajax.reload()
  toastr.success("item added")
}

$( document ).ready(function() {
  //errors to logfile pls
  $.fn.dataTable.ext.errMode = 'throw';
  //start tooltips if it is not a touch device
  var is_touch_device = 'ontouchstart' in document.documentElement;
  if (!is_touch_device) {
    $('[rel="tooltip"]').tooltip({trigger: "hover", delay: {show: 500, hide: 100}});
  }
  //now the js for the page can start
  toastr.info("welcome to Listless");
  listtable=$('#tableID').DataTable({
    ajax: {
      url: "./functions.php",
      data: {action:'get'},
      type: 'get',
      dataSrc: ""
    },
    order:[[1,'asc'],[0,'asc']],
    paging:   false,
    select: {
      style: 'single',
      info: false
    },
    columns: [
      { data: "line",
      title: 'Item',
      render: function (data, type, row){
        if(row['checked']==0){
          return data
        } else return '<font color="LightGray"><del>'+data+'</del></font>'
      }
    },
    { data: "category",
    title: 'Category',
    render: function (data, type, row){
      if(row['checked']==0){
        return data
      } else return '<font color="LightGray"><del>'+data+'</del></font>'
    }
  },
  { data: "checked",
  visible: false
},
{ data: "idlist",
visible: false}
]
});
//toggle checked for the selected row or edit form using global if in edit mode
//check the edit switch
listtable.on( 'select', function ( e, dt, type, indexes ) {
  if ( type === 'row' ) {
    selid = listtable.rows(indexes).data().pluck('idlist').valueOf();
    selitem = listtable.rows(indexes).data().pluck('line').valueOf();
    selcategory = listtable.rows(indexes).data().pluck('category').valueOf();
    seltick = listtable.rows(indexes).data().pluck('checked').valueOf();
    // do something with the ID of the selected items
    //console.log(selid[0], seltick[0])
    //Do we want to edit the item
    if($('#editModeSelect').prop('checked')){
      //console.log(selid[0], selitem[0], selcategory[0])
      //load the values into the edit modal
      document.getElementById("editItem").value=selitem[0]
      $.ajax({
        url: './functions.php',
        type: 'get',
        contentType: "application/json",
        dataType: 'json',
        data: {action:'getcategory'},
        success: function(data) {
          //called when successful
          //clear the dropdown in case you just removed one
          document.querySelector('#drop3').innerHTML=''
          $.each(data, function(idx, cat){
            //referring to this by id for variety
            document.querySelector('#drop3').innerHTML+='<li><a href="#" id="'+idx+'">'+cat+'</a></li>'
          })
          //set the category to current
          $("#dropdownMenu3:first-child").text(selcategory[0])
          $("#drop3 li a ").click(function(){
            $("#dropdownMenu3:first-child").text($(this).text());
            $("#dropdownMenu3u:first-child").val($(this).text());
          });
        }
      })
      //show the edit modal
      $('#editItemModal').modal('show')
    } else {
      //no edit, just a check
    if(seltick[0]==0){
      //set checked in db
      $.get("./functions.php",{action:'tickitem', tick:'1', idlist:selid[0]},function(){
        if($('#autoClearSelect').prop('checked')){
          //The autoClear
          removeTicked()
        } else {
          listtable.ajax.reload()
          toastr.success('checked')
        }
      });
    }
    if(seltick[0]==1){
      //remove checked in db
      $.get("./functions.php",{action:'tickitem', tick:'0', idlist:selid[0]},function(){
        listtable.ajax.reload()
      });
      toastr.success('unchecked')
    }
  }
}
})
});
//end of the page js
</script>
