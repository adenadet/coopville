require('./bootstrap');

window.Vue = require('vue');

//Import Progress Bar
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: 'rgb(255, 255, 19)',
    failedColor: 'red',
    height: '5px',
    });

//Import Sweet Alert
import Swal from 'sweetalert2'
window.Swal = Swal;

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

window.toast = toast;
//Import Moment for DateTime functions
import moment from 'moment';

//Import VueRouter for SPA Routing
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//Import Simple Pagination
Vue.component('pagination', require('laravel-vue-pagination'));

//Import Vform for forms and Errors
import {Form, HasError, AlertError} from 'vform';
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
window.Form = Form;

//Import Cart and ChartKick for Charts
import Chart from 'chart.js';
import Chartkick from 'vue-chartkick'
Vue.use(Chartkick.use(Chart));

//Import Emit for all components
window.Fire = new Vue();

//Import Multiselect Option
import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect)

import AdminActiveLoans from './components/admin/ActiveLoans.vue';
import AdminClosures from './components/admin/Closures.vue';
import AdminContribution from './components/admin/Contribution.vue';
import AdminDashboard from './components/admin/Dashboard.vue';
import AdminBranches from './components/admin/Branches.vue';
import AdminLoans from './components/admin/Loans.vue';
import AdminPendingClosures from './components/admin/PendingClosures.vue';
import AdminPendingLoans from './components/admin/PendingLoans.vue';
import AdminPendingWithdrawals from './components/admin/PendingWithdrawals.vue';
import AdminMembers from './components/admin/Members.vue';
import AdminRepayment from './components/admin/Repayment.vue';
import AdminPayments from './components/admin/Payments.vue';
import AdminSavings from './components/admin/Savings.vue';
import AdminWithdrawals from './components/admin/Withdrawals.vue';

import Contributions from './components/Contributions.vue';
import Dashboard from './components/Dashboard.vue';
import Guarantees from './components/Guarantees.vue';
import Guarantors from './components/Guarantors.vue';
import Loans from './components/Loans.vue';
import Profile from './components/Profile.vue';
import Savings from './components/Savings.vue';
import Withdrawals from './components/Withdrawals.vue';

//Declare Partials
import DetailBranchMember from './components/partials/details/BranchMembers.vue';
import DetailLoansAccount from './components/partials/details/LoansAccount.vue';
import DetailSavingsAccount from './components/partials/details/SavingsAccount.vue';
import DetailUserContributions from './components/partials/details/Contributions.vue';
import DetailUserRepayments from './components/partials/details/Repayments.vue';
import DetailUserSummary from './components/partials/details/Member.vue';
import DetailUserWithdrawals from './components/partials/details/Withdrawals.vue';

//Declare Form Components  
import FormAdminContribution from './components/partials/forms/AdminContribution.vue';
import FormAdminLoansAccount from './components/partials/forms/AdminLoansAccount.vue';
import FormAdminRepayment from './components/partials/forms/AdminRepayment.vue';
import FormAdminSavingsAccount from './components/partials/forms/AdminSavingsAccount.vue';
import FormAdminWithdrawal from './components/partials/forms/AdminWithdrawal.vue';
import FormAdminWithdrawalCon from './components/partials/forms/AdminWithdrawalCon.vue';

import FormBioData          from './components/partials/forms/BioData.vue';
import FormClosure          from './components/partials/forms/Closure.vue';
import FormConfirmPayment   from './components/partials/forms/ConfirmPayment.vue';
import FormContact          from './components/partials/forms/Contact.vue';
import FormContribution     from './components/partials/forms/Contribution.vue';
import FormGuarantee        from './components/partials/forms/Guarantee.vue';
import FormGuarantor        from './components/partials/forms/Guarantor.vue';
import FormLoan             from './components/partials/forms/Loan.vue';
import FormNextOfKin        from './components/partials/forms/NextOfKin.vue';
import FormRepayment        from './components/partials/forms/Repayment.vue';
import FormSavingsAccount   from './components/partials/forms/SavingsAccount.vue';
import FormSecurity         from './components/partials/forms/Security.vue';
import FormWithdrawal       from './components/partials/forms/Withdrawal.vue';

//Declare HRMS Forms
import UserForm from './components/profile/forms/BioData.vue';
import UserNOKForm from './components/profile/forms/NextOfKin.vue';
import UserPassword from './components/profile/forms/Password.vue';

Vue.component('Contributions', Contributions);
Vue.component('Dashboard', Dashboard);
Vue.component('Guarantees', Guarantees);
Vue.component('Guarantors', Guarantors);
Vue.component('Loans', Loans);
Vue.component('Profile', Profile);
Vue.component('Savings', Savings);
Vue.component('SavingsCreate', FormContribution);
Vue.component('Withdrawals', Withdrawals);

//All Details are declared here
Vue.component('DetailBranchMember', DetailBranchMember)
Vue.component('DetailLoansAccount', DetailLoansAccount)
Vue.component('DetailSavingsAccount', DetailSavingsAccount)
Vue.component('DetailUserContributions', DetailUserContributions)
Vue.component('DetailUserRepayments', DetailUserRepayments)
Vue.component('DetailUserSummary', DetailUserSummary)
Vue.component('DetailUserWithdrawals', DetailUserWithdrawals)

//All Forms are declared here
Vue.component('FormAdminContribution', FormAdminContribution);
Vue.component('FormAdminRepayment', FormAdminRepayment);
Vue.component('FormAdminLoansAccount', FormAdminLoansAccount);
Vue.component('FormAdminSavingsAccount', FormAdminSavingsAccount);
Vue.component('FormAdminWithdrawal', FormAdminWithdrawal);
Vue.component('FormAdminWithdrawalCon', FormAdminWithdrawalCon);


Vue.component('FormBioData', FormBioData);
Vue.component('FormClosure', FormClosure);
Vue.component('FormConfirmPayment', FormConfirmPayment);
Vue.component('FormContact', FormContact);
Vue.component('FormContribution', FormContribution);
Vue.component('FormGuarantee', FormGuarantee);
Vue.component('FormGuarantor', FormGuarantor);
Vue.component('FormLoan', FormLoan);
Vue.component('FormNextOfKin', FormNextOfKin);
Vue.component('FormRepayment', FormRepayment);
Vue.component('FormSavingsAccount', FormSavingsAccount);
Vue.component('FormSecurity', FormSecurity);

//All Profile Form
Vue.component('UserForm', UserForm);
Vue.component('UserNOKForm', UserNOKForm); 
Vue.component('UserPassword', UserPassword); 


//All Admin Pages
Vue.component('AdminActiveLoans', AdminActiveLoans);
Vue.component('AdminBranches', AdminBranches);
Vue.component('AdminClosures', AdminClosures);
Vue.component('AdminContribution', AdminContribution);
Vue.component('AdminDashboard', AdminDashboard);
Vue.component('AdminLoans', AdminLoans);
Vue.component('AdminMembers', AdminMembers);
Vue.component('AdminPayments', AdminPayments);
Vue.component('AdminPendingClosures', AdminPendingClosures);
Vue.component('AdminPendingLoans', AdminPendingLoans);
Vue.component('AdminPendingWithdrawals', AdminPendingWithdrawals);
Vue.component('AdminRepayment', AdminRepayment);
Vue.component('AdminSavings', AdminSavings);
Vue.component('AdminWithdrawals', AdminWithdrawals);

//Special Created Filters
Vue.filter('firstUp', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase(); 
    });

Vue.filter('ExcelDate', function(text){
    return moment(text).format('MMMM Do, YYYY');
    });

Vue.filter('currency', function(value) {
    let val = (value/1).toFixed(2).replace(',', '.')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    });

let routes = [
    {path: '/home', component: Dashboard},
    {path: '/admin_area/dashboard', component: AdminDashboard},
    {path: '/admin_area/branches', component: AdminBranches},
    {path: '/admin_area/closures/all', component: AdminClosures},
    {path: '/admin_area/closures/pending', component: AdminPendingClosures},
    {path: '/admin_area/contributions/create/:id', component: AdminContribution},
    {path: '/admin_area/contributions/create', component: AdminContribution},
    {path: '/admin_area/loans/active', component: AdminActiveLoans},
    {path: '/admin_area/loans/create', component: AdminLoans},
    {path: '/admin_area/loans/pending', component: AdminPendingLoans},
    {path: '/admin_area/members/:id', component: AdminMembers},
    {path: '/admin_area/members', component: AdminMembers},
    {path: '/admin_area/member/details/:id', component: DetailUserSummary},
    {path: '/admin_area/payments/:id', component: AdminPayments},
    {path: '/admin_area/repayments/create', component: AdminRepayment},
    {path: '/admin_area/savings/create/:id', component: AdminSavings},
    {path: '/admin_area/savings/create', component: AdminSavings},
    {path: '/admin_area/withdrawals/all', component: AdminWithdrawals},
    {path: '/admin_area/withdrawals/pending', component: AdminPendingWithdrawals},
    
    {path: '/member_area/dashboard', component: Dashboard},
    {path: '/member_area/closures', component: FormClosure},
    {path: '/member_area/contribution/create', component: FormContribution},
    {path: '/member_area/guarantees', component: Guarantees},
    {path: '/member_area/guarantors', component: Guarantors},
    {path: '/member_area/loans', component: Loans},
    {path: '/member_area/loans/create', component: FormLoan},
    {path: '/member_area/profile', component: Profile},
    {path: '/member_area/repayments', component: FormRepayment},
    {path: '/member_area/savings', component: Savings},
    {path: '/member_area/savings/create', component: FormSavingsAccount},
    {path: '/member_area/withdrawals', component: Withdrawals},
    {path: '/member_area/withdrawals/create', component: FormWithdrawal},
    ]

Vue.component('formcontact', FormContact);
Vue.component('formbiodata', FormBioData);
const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#corner',
    router,
});
