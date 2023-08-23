
const activityTypeDict = {
    'run': {
        label: 'Przebiegnięty dystans [km]',

    },
    'swim':{
        label: 'Przepłynięty dystans [m]',

    },
    'gym' : {
        label: false,

    },
    'walk':{
       label: 'Przebyty dystans [km]',

    } 
}


function changeLabelInfoByValue(slug){

    if(activityTypeDict[slug].label){
        activityValueLabelParent.classList.remove('display--none');
        activityValueLabel.innerHTML = activityTypeDict[slug].label;
    }else{
        activityValueLabelParent.classList.add('display--none');
    }

}

var activityValueLabel;
var activityValueLabelParent;
var activityTypeSelect;

document.addEventListener('DOMContentLoaded', ()=>{

    activityValueLabel = document.querySelector('#select-type-value');
    activityValueLabelParent = activityValueLabel.parentNode;

    activityTypeSelect = document.querySelector('#act_type');

    if(activityTypeSelect.getAttribute('data-selected') != '') changeLabelInfoByValue(activityTypeSelect.getAttribute('data-selected'))
    document.querySelector('#act_type').addEventListener('change',function(){
        let slug = activityTypeSelect.options[activityTypeSelect.selectedIndex];
        slug = slug.getAttribute('data-slug');
        changeLabelInfoByValue(slug);
    });

});