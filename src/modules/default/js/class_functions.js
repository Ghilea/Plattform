export default class Functions {
    constructor(){
    }

     reload(){
        $('#header').load(window.location.href + " #header > *");
        $('#indexContent').load(window.location.href + " #indexContent > *");
        console.log("Refreshed"); 
    }

}
