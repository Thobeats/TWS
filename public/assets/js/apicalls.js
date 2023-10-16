loadStates(selectedStateValue);


function loadStates(state=null){
    let select = document.getElementById('state');
    let jsn = '/states_cities.json';
    let option = '<option> Select State </option>';

    fetch(jsn)
        .then((response) => response.json())
        .then((json) => {
            for(variable in json){
                let selected = state == variable ? 'selected' : '';
                option += `
                <option ${selected} value='${variable}'>${variable}</option>
                `;
            }
            select.innerHTML = option;
        });
}

function selectCity(e,city=null){
    let state = e.target.value;
    let select = document.getElementById('city');
    let jsn = '/states_cities.json';
    let option = '<option> Select City </option>';

    fetch(jsn)
        .then((response) => response.json())
        .then((json) => {
            for(variable of json[state]){
                let selected = city == variable ? 'selected' : '';
                option += `
                <option ${selected} value='${variable}'>${variable}</option>
                `;
            }
            select.innerHTML = option;
        });
}


function uploadImage(e){
    let src = e.target.files[0];
    let target = e.target.dataset.target;
    document.getElementById(target).src = URL.createObjectURL(src);
}
