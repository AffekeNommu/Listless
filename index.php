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
      <style type="text/css"></style>
    </head>
    <body>
      <h1>Listless</h1>
     <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" onclick="loadCategories()" data-toggle="modal" data-target="#newItemModal" rel="tooltip" data-placement="bottom" title="add item" data-animation="true"><i class="material-icons">add</i></button>
      <button type="button" class="btn btn-primary" onclick="removeTicked()" rel="tooltip" data-placement="bottom" title="remove ticked" data-animation="true"><i class="material-icons">delete_sweep</i></button>
      <button type="button" class="btn btn-primary" onclick="undoRemoved()" rel="tooltip" data-placement="bottom" title="undo remove" data-animation="true"><i class="material-icons">undo</i></button>
      <div>
      <table class="table-responsive table-striped table-bordered table-condensed" id="tableID"></table>
      </div>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newCategoryModal" rel="tooltip" data-placement="bottom" title="add category" data-animation="true"><i class="material-icons">speaker_notes</i></button>
      <button type="button" class="btn btn-primary" onclick="selRemoveCategory()" data-toggle="modal" data-target="#delCategoryModal" rel="tooltip" data-placement="bottom" title="delete category" data-animation="true"><i class="material-icons">speaker_notes_off</i></button>
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
    $.each(data, function(idx, category){
        //console.log(category)
        cat=category //data[idx] would also work
        id=idx
        //console.log(idx)
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
    $.each(data, function(idx, category){
        cat=category
        id=idx
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
$.get("./functions.php",{action:'removeticked'},tickedRemoved);
toastr.success("cleared");
}

function undoRemoved(){
  $.get("./functions.php",{action:'undoremove'},tickedRemoved);
toastr.success("undone");
}

function tickedRemoved(){
  listtable.ajax.reload()
}
//todo - make an edit item
function edititem(){

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
  //start tooltips
  $('[rel="tooltip"]').tooltip({trigger: "hover"});
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
    //toggle checked for the selected row and maybe later for an edit form using global selid
    listtable.on( 'select', function ( e, dt, type, indexes ) {
        if ( type === 'row' ) {
            selid = listtable.rows(indexes).data().pluck('idlist').valueOf();
            seltick = listtable.rows(indexes).data().pluck('checked').valueOf();
            // do something with the ID of the selected items
            //console.log(selid[0], seltick[0])
            if(seltick[0]==0){
              //set checked in db
              $.get("./functions.php",{action:'tickitem', tick:'1', idlist:selid[0]},tickedRemoved);
	           toastr.success('checked')
	          }
            if(seltick[0]==1){
                //remove checked in db
		            $.get("./functions.php",{action:'tickitem', tick:'0', idlist:selid[0]},tickedRemoved);
		            toastr.success('unchecked')
            }
	     }
    })
});
//end of the page js
</script>
