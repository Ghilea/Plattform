import Functions from "./class_functions";

export default class Crud extends Functions {
    constructor(){
        super();
    }

    update(table, column, content, id, reload = false){
       
        $.post("/modules/default/update.php", 
        {
            'table': table, 
            'column': column, 
            'content': content, 
            'id': id
        }, function(data, status){
            console.log('Data: ' + data + "\nStatus: " + status);
        });

        if(reload){
            this.reload();
        }
        
    }

    update_checkbox(element, table, column, reload = false){
        let content;

        if(element.checked){
            content = 1;
        }else{
            content = 0;
        }

        $.post("/modules/default/update.php", 
        {
            'table': table, 
            'column': column, 
            'content': content, 
            'id': element.value
        }, function(data, status){
            console.log('Data: ' + data + "\nStatus: " + status);
        });

        if(reload){
            this.reload();
        }
        
    }

}
