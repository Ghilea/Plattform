    import Crud from './class_crud.js';
    let crud = new Crud();

    let menuBtnArray = [
        {'btn': 'sBtnModules', 'content': 'modulesContent', 'table': 'modules', 'column': 'moduleOn'}, 
        {'btn': 'sBtnConfig', 'content': 'configsContent', 'table': 'modules', 'column': 'moduleOn'}
    ];

    settingsMenuBtn();

    //functions
    function settingsMenuBtn(){

        menuBtnArray.forEach(element => {
        let btn = document.getElementById(element.btn);
        let content = document.getElementById(element.content);

            btn.addEventListener('click', function(){

                if(btn.checked){
                    
                    content.classList.remove('hiddenContent');

                    menuBtnArray.forEach(secElement =>{
                        
                        let secContent = document.getElementById(secElement.content);

                        if((content !== secContent)){
                            secContent.classList.add('hiddenContent');
                            document.getElementById(secElement.btn).checked = false;
                        }
                    });
                   
                }else{
                    content.classList.add('hiddenContent');
                }         
            });

            updateSwitchBtn('#' + element.content + ' input', element.table, element.column);

        }); 

        let configArrayItems = document.querySelectorAll('.configsContent__toggleBox');
    
        configArrayItems.forEach(configElement => {
            
            configElement.addEventListener('click', function(){
                console.log(configElement);
            });
        })

    }

    function updateSwitchBtn(inputValue, table, column) {
        let inputsElement = document.querySelectorAll(inputValue);

        inputsElement.forEach(element => {
            
            element.addEventListener('change', function(){
                crud.update_checkbox(element, table, column, true);
            });

        });
    }