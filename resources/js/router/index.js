import {createRouter , createWebHistory} from 'vue-router';

import Test from '../views/Test.vue';
import Families from '../views/Families.vue';
import Family from '../views/Family.vue';
import Person from '../views/Person.vue';
import Persons from '../views/Persons.vue';
import NewFamily from '../views/NewFamily.vue';
import EditFamily from '../views/EditFamily.vue';
import EditPerson from '../views/EditPerson.vue';
import NewPerson from '../views/NewPerson.vue';
import PageNotFound from '../views/404.vue';
import Certificate from '../views/Certificate.vue';

const routes=[
    {
        name:'Test',
        path:'/ttt',
        component:Test
    },
    {
        name:'TownFamilies',
        path:'/town-families',
        component:Families
    },
    {
        name:'Family',
        path:'/family/:family_id',
        component:Family
    },
    {
        name:'NewFamily',
        path:'/new-family',
        component:NewFamily
    },
    {
        name:'EditFamily',
        path:'/edit-family/:id',
        component:EditFamily
    },
    {
        name:'NewPerson',
        path:'/new-person/:family_id',
        component:NewPerson
    },
    {
        name:'EditPerson',
        path:'/edit-person/:id/:family_id',
        component:EditPerson
    },
    {
        name:'Persons',
        path:'/persons',
        component:Persons
    },
    {
        name:'Person',
        path:'/person/:person_id/:family_id',
        component:Person,
        props:true
    },
    {
        name:'Certificate',
        path:'/certificate/:type/:person_id',
        component:Certificate
    },
    {
        path:'/:pathMatch(.*)*',
        component:PageNotFound
    },
  
];

const router=createRouter({
    history:createWebHistory(),
    routes
})

export default router;