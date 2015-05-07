var taskArray = [];

  if (localStorage.length != 0) {
      for (e in localStorage) {
        taskArray[e] = localStorage.getItem(e);
      }
  }


  function show() {
    var task = $('#todo').val();
    if ( $('#todo').val() != '') {
      var count = taskArray.length;

      taskArray.push(task);
      $('.list').append("<div class='tasks'><input class='taskCheck' onclick='clickme(this)' type='checkbox'><span class='taskNo'>"+ count +"</span>&nbsp;<span class='task'>"+taskArray[count]+"</span></div>");
      $('#todo').val('');

      localStorage.clear();

      for (e in taskArray) {
        localStorage.setItem(e, taskArray[e]);
      }
    }
  }

  if (taskArray.length != 0) {
    for (var x = 0; x < taskArray.length; x++) {
      $('.list').append("<div class='tasks'><input class='taskCheck' onclick='clickme(this)' type='checkbox'><span class='taskNo'>"+ x +"</span>&nbsp;<span class='task'>"+taskArray[x]+"</span></div>");
    }
  }

  function clickme(x) {
    if (!x.checked) {
      $(x).checked = true;
      $("#delete").removeClass('showCross').addClass('hideCross');
    }
    if (x.checked) {
      $(x).checked = false;
      $("#delete").removeClass('hideCross').addClass('showCross');
    }
  }

  function del() {
    var count = taskArray.length;
    var checkedTasks = [];
    if (count > 0) {
      $('.taskCheck:checked').each(function(){
        checkedTasks.push($(this).next().next().html());
        $(this).parent().remove();
      });

      var index = 0;
      $('.taskNo').each(function(){$(this).html(index++)});
      console.log(checkedTasks);

      for (index in checkedTasks) {
        var arrIndex = taskArray.indexOf(checkedTasks[index]);
        taskArray.splice(arrIndex, 1);
      }

      localStorage.clear();
      for (e in taskArray) {
        localStorage.setItem(e, taskArray[e]);
      }
    }

    $("#delete").removeClass('showCross').addClass('hideCross');
  }