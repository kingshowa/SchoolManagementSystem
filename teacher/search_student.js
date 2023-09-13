function tableSearch(){
    let input,filter ,table ,tr,tnom, tpnom, textValue;

    input= document.getElementById('search-input');
    filter = input.value.toUpperCase();
    table = document.getElementById('search-table')
    tr = table.getElementsByTagName('tr')

    for(let i=0 ; i<tr.length; i++){
        tnom = tr[i].getElementsByTagName('td')[0];
        tpnom = tr[i].getElementsByTagName('td')[1];

        if(tnom || tpnom){
            textValue =   (tpnom.textContent || tpnom.innerText )  ;
            const   textValue2 =   (tnom.textContent || tnom.innerText)  ;
            if(textValue.toUpperCase().indexOf(filter) > -1  || textValue2.toUpperCase().indexOf(filter) > -1){
                tr[i].style.display="";
            }
            else{
                tr[i].style.display="none"
            }

        }

    }

}

