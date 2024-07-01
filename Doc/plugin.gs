function doPost(e) {
  var requestData = JSON.parse(e.postData.contents);
  var ss = SpreadsheetApp.getActiveSpreadsheet();
  var mainSheet = ss.getSheetByName('Manager');
  var debugSheet = ss.getSheetByName('Debug');
  if (!mainSheet) {
    mainSheet = ss.insertSheet('Manager');
  }
  if(mainSheet.getLastRow()===0){
    mainSheet.appendRow(['Task ID', 'Task Title', 'Description','Creation Date' ,'Due Date', 'Start Date', 'Last modification', 'Last move', 'Project Name', 'Project ID', 'Column Title', 'Priority', 'Assignee Name', 'Category Name', 'Category ID', 'Swimlane Name', 'Swimlane ID','Call Duration','Task Closed']);
  }
  if (!debugSheet) {
    debugSheet = ss.insertSheet('Debug');
  }
  if(debugSheet.getLastRow()===0){
    debugSheet.appendRow(['Task ID', 'Event Name', 'Event Data', 'Timestamp']);
  }
  var eventName = requestData.eventName;
  var eventData = requestData.eventData;
  var taskID = eventData.task.id;
  var taskTitle = eventData.task.title;
  var taskDescription = eventData.task.description;
  var creationDate = new Date(eventData.task.date_creation*1000);
  var startDate = eventData.task.date_started === 0 ? 'Unknown' : new Date(eventData.task.date_started * 1000);
  var endDate = eventData.task.date_due === 0 ? 'Unknown' : new Date(eventData.task.date_due * 1000);
  var lastModifDate = new Date(eventData.task.date_modification * 1000);
  var lastMoveDate = new Date(eventData.task.date_moved * 1000);
  var projectName = eventData.task.project_name;
  var projectID = eventData.task.project_id;
  var columnTitle = eventData.task.column_title;
  var priority = eventData.task.priority;
  var assigneeName = eventData.task.assignee_name === null? 'Unassigned' : eventData.task.assignee_name ;
  var categoryName = eventData.task.category_name=== null ?'Unknown Category' : eventData.task.category_name;
  var categoryID = eventData.task.category_id;
  var swimlaneName = eventData.task.swimlane_name===null ?'Unknown Swimlane':eventData.task.swimlane_name;
  var swimlaneID = eventData.task.swimlane_id;
  var callDuration = eventData.task.time_estimated ===0 ? 0:eventData.task.time_estimated*60;
  var taskColor = eventData.task.color_id || 'yellow';
  var taskClosed = false;
  var status = 'Non'; 

  var colorMap = {
      'yellow': '#ffff00',
      'blue': '#0000ff',
      'green': '#00ff00',
      'purple': '#800080',
      'red': '#ff0000',
      'orange': '#ffa500',
      'grey': '#808080',
      'brown': '#a52a2a',
      'deep orange': '#ff4500',
      'dark grey': '#a9a9a9',
      'pink': '#ffc0cb',
      'teal': '#008080',
      'cyan': '#00ffff',
      'lime': '#00ff00',
      'light green': '#90ee90',
      'amber': '#ffbf00',
      'default': '#ffffff'
    };
    
  var color = colorMap[taskColor.toLowerCase()] || colorMap['default'];
  debugSheet.appendRow([taskID, eventName, JSON.stringify(eventData), new Date()]);

  var idColumnValues = mainSheet.getRange('A:A').getValues();
  var rowIndex = idColumnValues.findIndex(function(row) {
    return row[0] === taskID;
  });
    if(eventName === 'task.close'){
    if (rowIndex !== -1) {
      var rowToUpdate = rowIndex + 1;
      taskClosed = true;
      status = 'Oui';
      mainSheet.getRange('S' + rowToUpdate).setValue(status);
  }
  }
  if(eventName === 'task.open'){
    if (rowIndex !== -1) {
      var rowToUpdate = rowIndex + 1;
      taskClosed = false;
      status = 'Non';
      mainSheet.getRange('S' + rowToUpdate).setValue(status); 
      }
  }
  if (rowIndex === -1) {
    var lastRow = mainSheet.getLastRow()+1;
    mainSheet.appendRow([taskID, taskTitle, taskDescription, creationDate, startDate, endDate, lastModifDate, lastMoveDate, projectName, projectID, columnTitle, priority, assigneeName, categoryName, categoryID, swimlaneName, swimlaneID, callDuration, status]);
    mainSheet.getRange('A' + lastRow + ':S' + lastRow).setBackground(color);

  } else {
    var rowToUpdate = rowIndex + 1;
    var currentStatus = mainSheet.getRange('S' + rowToUpdate).getValue();
    if(currentStatus === 'Oui')
        status = 'Oui';
        
    mainSheet.getRange('A' + rowToUpdate + ':S' + rowToUpdate).setValues([[taskID, taskTitle, taskDescription, creationDate, startDate, endDate, lastModifDate, lastMoveDate, projectName, projectID, columnTitle, priority, assigneeName, categoryName, categoryID, swimlaneName, swimlaneID, callDuration,status]]);
    mainSheet.getRange('A' + rowToUpdate + ':S' + rowToUpdate).setBackground(color);
    if(eventName === 'task.close'){
    if (rowIndex !== -1) {
      var rowToUpdate = rowIndex + 1; // Ajouter 1 car les indices des lignes commencent à 1
      mainSheet.getRange('S' + rowToUpdate).setValue('Oui'); // Suppose que la colonne "Task Closed" est la colonne S
      taskClosed = true;
      status = 'Oui';
  }
  }
  }
  return ContentService.createTextOutput('Données reçues et traitées avec succès');
}
