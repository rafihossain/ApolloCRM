<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Autho Routes
require __DIR__.'/auth.php';

// Language Switch
Route::get('language/{language}', 'LanguageController@switch')->name('language.switch');

/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    Route::get('/', 'FrontendController@index')->name('index');
    Route::get('home', 'FrontendController@index')->name('home');
    Route::get('privacy', 'FrontendController@privacy')->name('privacy');
    Route::get('terms', 'FrontendController@terms')->name('terms');

    Route::group(['middleware' => ['auth']], function () {
        /*
        *
        *  Users Routes
        *
        * ---------------------------------------------------------------------
        */
        $module_name = 'users';
        $controller_name = 'UserController';
        Route::get('profile/{id}', ['as' => "$module_name.profile", 'uses' => "$controller_name@profile"]);
        Route::get('profile/{id}/edit', ['as' => "$module_name.profileEdit", 'uses' => "$controller_name@profileEdit"]);
        Route::patch('profile/{id}/edit', ['as' => "$module_name.profileUpdate", 'uses' => "$controller_name@profileUpdate"]);
        Route::get("$module_name/emailConfirmationResend/{id}", ['as' => "$module_name.emailConfirmationResend", 'uses' => "$controller_name@emailConfirmationResend"]);
        Route::get('profile/changePassword/{username}', ['as' => "$module_name.changePassword", 'uses' => "$controller_name@changePassword"]);
        Route::patch('profile/changePassword/{username}', ['as' => "$module_name.changePasswordUpdate", 'uses' => "$controller_name@changePasswordUpdate"]);
        Route::delete('users/userProviderDestroy', ['as' => 'users.userProviderDestroy', 'uses' => 'UserController@userProviderDestroy']);
    });
});

/*
*
* Backend Routes
* These routes need view-backend permission
* --------------------------------------------------------------------
*/
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth', 'can:view_backend']], function () {

    /**
     * Backend Dashboard
     * Namespaces indicate folder structure.
     */
    Route::get('/', 'BackendController@index')->name('home');
    Route::get('dashboard', 'BackendController@index')->name('dashboard');
    
    //office visit
    Route::get('/officevisit/waiting', ['as' => "office-visit-waiting", 'uses' => "OfficeVisitController@officeVisitWaiting"]);

    Route::post('office-visit-create', ['as' => 'create-office-waiting','uses' => 'OfficeVisitController@createOfficeWaiting']);
    Route::get('office-visit-edit', ['as' => 'edit-office-waiting','uses' => 'OfficeVisitController@editOfficeWaiting']);
    Route::post('office-visit-update', ['as' => 'update-office-waiting','uses' => 'OfficeVisitController@updateOfficeWaiting']);
    Route::get('office-visit-delete/{id}', ['as' => 'delete-office-waiting','uses' => 'OfficeVisitController@deleteOfficeWaiting']);


    Route::get('/officevisit/attending', ['as' => "office-visit-attending", 'uses' => "OfficeVisitController@officeVisitAttending"]);
    Route::get('/officevisit/completed', ['as' => "office-visit-completed", 'uses' => "OfficeVisitController@officeVisitCompleted"]);
    Route::get('/officevisit/all', ['as' => "office-visit-all", 'uses' => "OfficeVisitController@officeVisitAll"]);
    Route::get('/officevisit/archived', ['as' => "office-visit-archived", 'uses' => "OfficeVisitController@officeVisitArchived"]);

    //==================== RS SOFTWARE start here =======================
    Route::get('add-list', ['as' => "add-list.addList", 'uses' => "AddsController@addList"]);
    Route::get('categorie-list', ['as' => "categorie-list.categorieList", 'uses' => "AddsController@categorieList"]);
    Route::get('add-categorie', ['as' => "add-categorie.addCategorie", 'uses' => "AddsController@addCategorie"]);
    Route::get('brand-list', ['as' => "brand-list.brandList", 'uses' => "AddsController@brandList"]);
    Route::get('add-brand', ['as' => "add-brand.addBrand", 'uses' => "AddsController@addBrand"]);
    Route::post('save-brand', ['as' => "save-brand.saveBrand", 'uses' => "AddsController@saveBrand"]);
    Route::get('brand-edit/{id}', ['as' => "brand-edit.brandEdit", 'uses' => "AddsController@brandEdit"]);
    Route::post('brand-update/{id}', ['as' => "update-brand.updateBrand", 'uses' => "AddsController@updateBrand"]);

    /*--------------------------------------------------------
                        teams
    ----------------------------------------------------------*/

    //Offices
    Route::get('offices/add', ['as' => "add-offices", 'uses' => "OfficesController@addOfficers"]);
    Route::get('offices/list', ['as' => "manage-offices", 'uses' => "OfficesController@manageOfficers"]);
    Route::post('offices/save', ['as' => 'save-offices','uses' => 'OfficesController@saveOfficers']);
    Route::get('offices/edit/{id}', ['as' => 'edit-offices','uses' => 'OfficesController@editOfficers']);
    Route::post('offices/update', ['as' => 'update-offices','uses' => 'OfficesController@updateOfficers']);
    Route::get('offices/delete/{id}', ['as' => 'delete-offices','uses' => 'OfficesController@deleteOfficers']);
    
    Route::get('branch/{id}', ['as' => 'branch-details','uses' => 'OfficesController@branchDetails']);
    Route::get('branch/clients/{id}', ['as' => 'branch-clients','uses' => 'OfficesController@branchClients']);

    //users-----------
    Route::get('users/add', ['as' => "create-users", 'uses' => "UserManageController@createUsers"]);
    Route::get('users/list', ['as' => "manage-users", 'uses' => "UserManageController@manageUsers"]);
    Route::post('users/save', ['as' => 'save-users','uses' => 'UserManageController@saveUsers']);
    Route::get('users/edit/{id}', ['as' => 'edit-users','uses' => 'UserManageController@editUsers']);
    Route::post('users/update', ['as' => 'update-users','uses' => 'UserManageController@updateUsers']);
    Route::get('users/delete/{id}', ['as' => 'delete-users','uses' => 'UserManageController@deleteUsers']);
    Route::get('users/details/{id}', ['as' => "usersdetails", 'uses' => "UserManageController@usersdetails"]);
    Route::get('users/datetime/{id}', ['as' => "user_datetime", 'uses' => "UserManageController@user_datetime"]);
    Route::post('users/timezone/save/{id}', ['as' => "user_timezone_save", 'uses' => "UserManageController@user_timezone_save"]);
    Route::get('users/kpi/{id}', ['as' => "user_kpi", 'uses' => "UserManageController@user_kpi"]);
    Route::post('users/kpi/save', ['as' => "save_kpi_target", 'uses' => "UserManageController@save_kpi_target"]);
    Route::get('users/inactive/{id}', ['as' => "user_inactive", 'uses' => "UserManageController@user_inactive"]);
    Route::get('users/inactive', ['as' => "usersinactive", 'uses' => "UserManageController@usersinactive"]);
    Route::get('users/active/{id}', ['as' => "user_active", 'uses' => "UserManageController@user_active"]);
    Route::get('users/invited', ['as' => "usersinvited", 'uses' => "UserManageController@usersinvited"]);
    Route::get('users/invite/cancel/{id}', ['as' => "cancel_invite",'uses' => "UserManageController@cancel_invite"]);
    

    //client
    Route::get('client/add', ['as' => "add-client", 'uses' => "ClientController@addClient"]);
    //Route::get('client/list', ['as' => "manage-client", 'uses' => "ClientController@manageClient"]);
    Route::get('client/prospects', ['as' => "manage-prospects", 'uses' => "ClientController@manageProspects"]);
    Route::get('client/activitie/{id}', ['as' => "manage-activitie", 'uses' => "ClientController@clientProfileActivitie"]);
    
    Route::get('client/clients', ['as' => "manage-clients", 'uses' => "ClientController@manageClient"]);
    Route::get('client/archived', ['as' => "manage-archived", 'uses' => "ClientController@manageArchived"]);
    Route::post('client/save', ['as' => 'save-client','uses' => 'ClientController@saveClient']);
    Route::get('client/edit/{id}', ['as' => 'edit-client','uses' => 'ClientController@editClient']);
    Route::post('client/update', ['as' => 'update-client','uses' => 'ClientController@updateClient']);
    
    Route::get('client/archived/{id}', ['as' => 'delete-client','uses' => 'ClientController@archiveClient']);
    Route::get('client/restore/{id}', ['as' => 'restore-client','uses' => 'ClientController@restoreClient']);
    
    Route::get('client/view/{id}', ['as' => 'view-client','uses' => 'ClientController@viewClient']);
    Route::get('client/autocomplete', ['as' => "manage-autocomplete", 'uses' => "ClientController@autocomplete"]);
    Route::get('client/sourceautocomplete', ['as' => "manage-autosource", 'uses' => "ClientController@sourceAutocomplete"]);
    Route::get('client/applicationautocomplete', ['as' => "manage-autoapplication", 'uses' => "ClientController@applicationAutocomplete"]);
    
    Route::get('application/info/append', ['as' => 'application-info-append','uses' => 'ClientController@applicationInfoAppend']);
    
    
    /*===============================================================================
                            Client Profile Start
    =================================================================================*/
    //activities
    Route::get('client/profile/activities/{id}', ['as' => 'client-profile-activities','uses' => 'ClientController@clientProfileActivities']);
    
    //applications
    Route::get('client/profile/applications/{id}', ['as' => 'client-profile-applications','uses' => 'ClientController@clientProfileApplications']);
    Route::get('service-workflow', ['as' => "service_workflow", 'uses' => "ClientController@serviceWorkflow"]);
    Route::get('product-info', ['as' => "product_info", 'uses' => "ClientController@productInfo"]);
    Route::get('partner-info', ['as' => "partner_branch", 'uses' => "ClientController@partnerBranch"]);
    Route::post('client-save-application', ['as' => "save-client-application", 'uses' => "ClientController@saveClientApplication"]);

    //application details
    Route::get('client/profile/application/details/{id}/{client_id}', ['as' => 'client-profile-application-details','uses' => 'ClientController@clientProfileApplicationDetails']);
    Route::post('application-add-note', ['as' => "application-add-note", 'uses' => "ClientController@applicationAddNote"]);
    Route::post('application-add-dcumentation', ['as' => "application-add-documentation", 'uses' => "ClientController@applicationAddDocumentation"]);
    Route::post('application-add-appointment', ['as' => "application-add-appointment", 'uses' => "ClientController@applicationAddAppointment"]); 
    Route::post('application-send-mail', ['as' => "application-send-mail", 'uses' => "ClientController@applicationSendMail"]); 
    
    Route::get('application-docs/{aid}/{client_id}', ['as' => "application-docs", 'uses' => "ClientController@applicationDocs"]); 
    Route::get('application-edit-docs/{aid}', ['as' => "application-edit-docs", 'uses' => "ClientController@applicationEditDocs"]); 
    Route::get('application-delete-docs/{aid}', ['as' => "application-delete-docs", 'uses' => "ClientController@applicationDeleteDocs"]); 
    
    Route::get('application-notes/{aid}/{client_id}', ['as' => "application-notes", 'uses' => "ClientController@applicationNotes"]); 
    Route::get('application-edit-notes/{aid}', ['as' => "application-edit-notes", 'uses' => "ClientController@applicationEditNotes"]); 
    Route::get('application-delete-notes/{aid}', ['as' => "application-delete-notes", 'uses' => "ClientController@applicationDeleteNotes"]); 

    Route::post('application-addclient-task/{aid}/{client_id}', ['as' => "application-addclient-task", 'uses' => "ClientController@applicationClientAddTask"]); 
    Route::get('application-catewise-task/{aid}/{client_id}/{cat_id}', ['as' => "application-catewise-task", 'uses' => "ClientController@getClientTaskCategory"]);
    
    
    
    /*=========================================================================================================
                                        quotation start
    ===========================================================================================================*/

    //quotation-template
    Route::get('quotations/template/list', ['as' => 'quotations-template-list','uses' => 'QuotationsController@QuotationsTemplateList']);
    Route::get('quotations/template/add', ['as' => 'quotations-template-add','uses' => 'QuotationsController@QuotationsTemplateAdd']);
    Route::post('quotations/template/save', ['as' => 'quotations-template-save','uses' => 'QuotationsController@QuotationsTemplateSave']);

    Route::post('quotations/template/create', ['as' => 'quotations-template-create','uses' => 'QuotationsController@QuotationsTemplateCreate']);
    Route::get('quotations/template/use/{id}/{client_id}', ['as' => 'quotations-template-use','uses' => 'QuotationsController@QuotationsTemplateUse']);
    Route::post('quotations/template/submit', ['as' => 'quotations-template-submit','uses' => 'QuotationsController@QuotationsTemplateSubmit']);
    
    Route::get('quotations/template/edit/{id}', ['as' => 'quotations-template-edit','uses' => 'QuotationsController@QuotationsTemplateEdit']);
    Route::post('quotations/template/update', ['as' => 'quotations-template-update','uses' => 'QuotationsController@QuotationsTemplateUpdate']);
    Route::get('quotations/template/delete/{id}', ['as' => 'quotations-template-delete','uses' => 'QuotationsController@QuotationsTemplateDelete']);


    //active-quotation
    Route::get('quotations/active/list', ['as' => 'quotations-active-list','uses' => 'QuotationsController@QuotationsActiveList']);
    Route::post('quotations/active/create', ['as' => 'quotations-active-create','uses' => 'QuotationsController@QuotationsActiveCreate']);

    Route::get('quotations/active/edit/{id}', ['as' => 'quotations-active-edit','uses' => 'QuotationsController@QuotationsActiveEdit']);
    Route::post('quotations/active/update', ['as' => 'quotations-active-update','uses' => 'QuotationsController@QuotationsActiveUpdate']);


    Route::get('quotations/preview/{id}', ['as' => 'quotations-preview','uses' => 'QuotationsController@QuotationPreview']);


    //archived-quotation
    Route::get('quotations/archived/list', ['as' => 'quotations-archived-list','uses' => 'QuotationsController@QuotationsArchivedList']);
    Route::get('quotations/archived/preview/{id}', ['as' => 'quotations-achived-preview','uses' => 'QuotationsController@QuotationArchivedPreview']);

    Route::get('quotations/archived/{id}', ['as' => 'quotations-archived','uses' => 'QuotationsController@QuotationsArchived']);
    Route::get('quotations/decline/{id}', ['as' => 'quotations-decline','uses' => 'QuotationsController@QuotationsDecline']);
    
    Route::get('quotations/archive/delete/{id}', ['as' => 'quotations-archive-delete','uses' => 'QuotationsController@QuotationsArchiveDelete']);
    /*=========================================================================================================
                                        quotation end
    ===========================================================================================================*/
    
    
    
 
    //services
    Route::get('client/profile/services/{id}', ['as' => 'client-profile-services','uses' => 'ClientController@clientProfileService']);
    Route::post('client-service-create', ['as' => 'addclient-service','uses' => 'ClientController@clientServiceCreate']);
    Route::post('client-service-edit', ['as' => 'editclient-service','uses' => 'ClientController@clientServiceEdit']);
    Route::post('client-service-view', ['as' => 'viewclient-service','uses' => 'ClientController@clientServiceView']);
    Route::post('client-service-update', ['as' => 'updateclient-service','uses' => 'ClientController@clientServiceUpdate']);
    Route::get('client-service-delete/{id}/{client_id}', ['as' => 'deleteclient-service','uses' => 'ClientController@clientServiceDelete']);

    //documents
    Route::get('client/profile/documents/{id}', ['as' => 'client-profile-documents','uses' => 'ClientController@clientProfileDocuments']);
    Route::post('client-document-create', ['as' => 'addclient-document','uses' => 'ClientController@clientDocumentCreate']);
    Route::get('client-document-delete/{id}/{client_id}', ['as' => 'deleteclient-document','uses' => 'ClientController@clientDocumentDelete']);
    
    //appointments
    Route::get('client/profile/appointments/{id}', ['as' => 'client-profile-appointments','uses' => 'ClientController@clientProfileAppointments']);
    Route::post('client-appointment-create', ['as' => 'addclient-appointment','uses' => 'ClientController@clientAppointmentCreate']);
    Route::post('client-appointment-edit', ['as' => 'editclient-appointment','uses' => 'ClientController@clientAppointmentEdit']);
    Route::post('client-appointment-update', ['as' => 'updateclient-appointment','uses' => 'ClientController@clientAppointmentUpdate']);
    Route::get('client-appointment-delete{id}/{client_id}', ['as' => 'deleteclient-appointment','uses' => 'ClientController@clientAppointmentDelete']);
    
    //notes
    Route::get('client/profile/notes/{id}', ['as' => 'client-profile-notes','uses' => 'ClientController@clientProfileNotes']);
    Route::post('client-note-create', ['as' => 'addclient-note','uses' => 'ClientController@clientNoteCreate']);
    Route::post('client-note-edit', ['as' => 'editclient-note','uses' => 'ClientController@clientNoteEdit']);
    Route::post('client-note-update', ['as' => 'updateclient-note','uses' => 'ClientController@clientNoteUpdate']);
    Route::get('client-note-delete/{id}/{client_id}', ['as' => 'deleteclient-note','uses' => 'ClientController@clientNoteDelete']);
    
    
    
    //quotations
    Route::get('client/profile/quotations/{id}', ['as' => 'client-profile-quotations','uses' => 'ClientController@clientProfileQuotations']);
    Route::get('client/profile/quotationslist/{id}', ['as' => 'client-profile-quotationslist','uses' => 'ClientController@clientProfileQuotationslist']);
    Route::get('client/profile/quotationsedit/{id}', ['as' => 'client-profile-quotationsedit','uses' => 'ClientController@clientProfileQuotationsEdit']);
    Route::get('client/profile/quotationsdelete/{id}', ['as' => 'client-profile-quotationsdelete','uses' => 'ClientController@clientProfileQuotationsDelete']);

    Route::get('client/profile/quotations/add/{id}', ['as' => 'client-profile-quotations-add','uses' => 'ClientController@clientProfileQuotationsAdd']);
    Route::post('client/profile/quotations/addsubmit/{id}', ['as' => 'client-profile-quotations-addsubmit','uses' => 'ClientController@clientProfileQuotationsAddsubmit']);
    Route::post('client/profile/quotations/createhtml', ['as' => 'client-profile-quotations-createhtml','uses' => 'ClientController@clientProfileCreatehtml']);
    Route::post('client/profile/quotations/updatesubmit/{id}', ['as' => 'client-profile-quotations-updatesubmit','uses' => 'ClientController@clientProfileQuotationsUpdatesubmit']);
   
   
   
    Route::post('client/profile/quotations/option', ['as' => 'client-profile-quotations-option','uses' => 'ClientController@clientProfileOption']);
    Route::post('client/profile/quotations/editoption', ['as' => 'client-profile-quotations-editoption','uses' => 'ClientController@clientProfileEditoption']);
    //accounts
    Route::get('client/profile/accounts/{id}', ['as' => 'client-profile-accounts','uses' => 'ClientController@clientProfileAccounts']);
    //conversation
    Route::get('client/profile/conversation/{id}', ['as' => 'client-profile-conversation','uses' => 'ClientController@clientProfileConversation']);
    
    //tasks
    Route::get('client/profile/tasks/{id}', ['as' => 'client-profile-tasks','uses' => 'ClientController@clientProfileTasks']);
    Route::post('client-task-create', ['as' => 'addclient-task','uses' => 'ClientController@clientTaskCreate']);
    Route::post('client-task-edit', ['as' => 'editclient-task','uses' => 'ClientController@clientTaskEdit']);
    Route::post('client-task-update', ['as' => 'updateclient-task','uses' => 'ClientController@clientTaskUpdate']);
    Route::get('client-task-delete{id}/{client_id}', ['as' => 'deleteclient-task','uses' => 'ClientController@clientTaskDelete']);
    
    //educations
    Route::get('client/profile/educations/{id}', ['as' => 'client-profile-educations','uses' => 'ClientController@clientProfileEducations']);
    Route::post('client-education-create', ['as' => 'addclient-education','uses' => 'ClientController@clientEducationCreate']);
    Route::post('client-education-edit', ['as' => 'editclient-education','uses' => 'ClientController@clientEducationEdit']);
    Route::post('client-education-update', ['as' => 'updateclient-education','uses' => 'ClientController@clientEducationUpdate']);
    Route::get('client-education-delete/{id}/{client_id}', ['as' => 'deleteclient-education','uses' => 'ClientController@clientEducationDelete']);
    
    Route::get('client-subject-info', ['as' => 'subject_info','uses' => 'ClientController@clientSubjectInfo']);
    Route::post('update-education-score', ['as' => 'update-education-score','uses' => 'ClientController@updateEducationScore']);
    Route::post('update-other-score', ['as' => 'update-other-score','uses' => 'ClientController@updateOtherScore']);
    
    
    //informations
    Route::get('client/profile/informations/{id}', ['as' => 'client-profile-informations','uses' => 'ClientController@clientProfileInformations']);
    //logs
    Route::get('client/profile/logs/{id}', ['as' => 'client-profile-logs','uses' => 'ClientController@clientProfileLogs']);
    
    
    
    
    /*===============================================================================
                            Client Profile End
    =================================================================================*/

    //application
    Route::get('application/list', ['as' => "manage-application", 'uses' => "ApplicationController@manageApplication"]);
    
    //partner
    Route::get('partner/add', ['as' => "add-partner", 'uses' => "PartnerController@addPartner"]);
    Route::get('partner/list', ['as' => "manage-partner", 'uses' => "PartnerController@managePartner"]);
    Route::post('partner/save', ['as' => "save-partner",'uses' => 'PartnerController@savePartner']);

    Route::get('partneredit/{id}', ['as' => "partneredit", 'uses' => "PartnerController@editPartner"]);
    Route::post('partnerupdate', ['as' => 'updatepartner','uses' => 'PartnerController@updatePartner']);
    Route::get('partnerdelete/{id}', ['as' => 'partnerdelete','uses' => 'PartnerController@deletePartner']);
    Route::get('partner/type', ['as' => "get-partner-type", 'uses' => "PartnerController@getPartnerType"]);

    /*=======================================================================================
                                        Partner profile start
   ===========================================================================================*/

    //application
    Route::get('partner/profile/applications/{id}', ['as' => 'partner-profile-application','uses' => 'PartnerController@partnerProfileApplication']);
    
    //products
    Route::get('partner/profile/products/{id}', ['as' => 'partner-profile-product','uses' => 'PartnerController@partnerProfileProduct']);
    Route::get('partner/add/product/{id}', ['as' => 'partner-product-add','uses' => 'PartnerController@partnerProfileAdd']);
    Route::post('partner/create/product', ['as' => 'partner-product-create','uses' => 'PartnerController@partnerProfileCreate']);
    
    //branch
    Route::get('partner/profile/branche/{id}', ['as' => 'partner-profile-branche','uses' => 'PartnerController@partnerProfileBranche']);
    Route::post('partner-branch-create', ['as' => "addpartner-branch", 'uses' => "PartnerController@createPartnerBranch"]);
    Route::post('partner-branch-edit', ['as' => "editpartner-branch", 'uses' => "PartnerController@editPartnerBranch"]);
    Route::post('partner-branch-update', ['as' => "updatepartner-branch", 'uses' => "PartnerController@updatePartnerBranch"]);
    Route::get('partner-branch-delete/{id}/{partner_id}', ['as' => "deletepartner-branch", 'uses' => "PartnerController@deletePartnerBranch"]);

    //agreement
    Route::get('partner/profile/agreement/{id}', ['as' => 'partner-profile-agreement','uses' => 'PartnerController@partnerProfileAgreement']);
    Route::post('partner/profile/update', ['as' => 'update-partner-agreement','uses' => 'PartnerController@updatePartnerAgreement']);

    //contact
    Route::get('partner/profile/contact/{id}', ['as' => 'partner-profile-contact','uses' => 'PartnerController@partnerProfileContact']);

    Route::post('partner-contact-create', ['as' => "addpartner-contact", 'uses' => "PartnerController@createPartnerContact"]);
    Route::post('partner-contact-edit', ['as' => "editpartner-contact", 'uses' => "PartnerController@editPartnerContact"]);
    Route::post('partner-contact-update', ['as' => "updatepartner-contact", 'uses' => "PartnerController@updatePartnerContact"]);
    Route::get('partner-contact-delete/{id}/{partner_id}', ['as' => "deletepartner-contact", 'uses' => "PartnerController@deletePartnerContact"]);

    //note
    Route::get('partner/profile/note/{id}', ['as' => 'partner-profile-note','uses' => 'PartnerController@partnerProfileNote']);
    Route::post('partner-note-create', ['as' => 'addpartner-note','uses' => 'PartnerController@partnerNoteCreate']);
    Route::post('partner-note-edit', ['as' => 'editpartner-note','uses' => 'PartnerController@partnerNoteEdit']);
    Route::post('partner-note-update', ['as' => 'updatepartner-note','uses' => 'PartnerController@partnerNoteUpdate']);
    Route::get('partner-note-delete/{id}/{partner_id}', ['as' => 'deletepartner-note','uses' => 'PartnerController@partnerNoteDelete']);

    //document
    Route::get('partner/profile/document/{id}', ['as' => 'partner-profile-document','uses' => 'PartnerController@partnerProfileDocument']);
    Route::post('partner-document-create', ['as' => 'addpartner-document','uses' => 'PartnerController@partnerDocumentCreate']);
    Route::get('partner-document-delete/{id}/{partner_id}', ['as' => 'deletepartner-document','uses' => 'PartnerController@partnerDocumentDelete']);

    //appointment
    Route::get('partner/profile/appointment/{id}', ['as' => 'partner-profile-appointment','uses' => 'PartnerController@partnerProfileAppointment']);
    Route::post('partner-appointment-create', ['as' => 'addpartner-appointment','uses' => 'PartnerController@partnerAppointmentCreate']);
    Route::post('partner-appointment-edit', ['as' => 'editpartner-appointment','uses' => 'PartnerController@partnerAppointmentEdit']);
    Route::post('partner-appointment-update', ['as' => 'updatepartner-appointment','uses' => 'PartnerController@partnerAppointmentUpdate']);
    Route::get('partner-appointment-delete{id}/{partner_id}', ['as' => 'deletepartner-appointment','uses' => 'PartnerController@partnerAppointmentDelete']);
    
    //account
    Route::get('partner/profile/account/{id}', ['as' => 'partner-profile-account','uses' => 'PartnerController@partnerProfileAccount']);
    //conversation
    Route::get('partner/profile/conversation/{id}', ['as' => 'partner-profile-conversation','uses' => 'PartnerController@partnerProfileConversation']);
    
    //task
    Route::get('partner/profile/task/{id}', ['as' => 'partner-profile-task','uses' => 'PartnerController@partnerProfileTask']);
    Route::post('partner-task-create', ['as' => 'addpartner-task','uses' => 'PartnerController@partnerTaskCreate']);
    Route::post('partner-task-edit', ['as' => 'editpartner-task','uses' => 'PartnerController@partnerTaskEdit']);
    Route::post('partner-task-update', ['as' => 'updatepartner-task','uses' => 'PartnerController@partnerTaskUpdate']);
    Route::get('partner-task-delete{id}/{partner_id}', ['as' => 'deletepartner-task','uses' => 'PartnerController@partnerTaskDelete']);
    
    //otherinformation
    Route::get('partner/profile/otherinformation/{id}', ['as' => 'partner-profile-otherinformation','uses' => 'PartnerController@partnerProfileOtherinformation']);
    
    //promotion
    Route::get('partner/profile/promotion/{id}', ['as' => 'partner-profile-promotion','uses' => 'PartnerController@partnerProfilePromotion']);
    Route::post('partner-promotion-create', ['as' => 'addpartner-promotion','uses' => 'PartnerController@partnerPromotionCreate']);
    Route::post('partner-promotion-edit', ['as' => 'editpartner-promotion','uses' => 'PartnerController@partnerPromotionEdit']);
    Route::post('partner-promotion-update', ['as' => 'updatepartner-promotion','uses' => 'PartnerController@partnerPromotionUpdate']);
    Route::post('partner-promotion-view', ['as' => 'viewpartner-promotion','uses' => 'PartnerController@partnerPromotionView']);
    Route::get('partner-promotion-delete{id}/{partner_id}', ['as' => 'deletepartner-promotion','uses' => 'PartnerController@partnerPromotionDelete']);

    /*=======================================================================================
                                        Partner profile end
   ===========================================================================================*/
    
    //product
    Route::get('product/list', ['as' => "manage-product", 'uses' => "ProductController@manageProduct"]);
    Route::get('addproduct', ['as' => "add-product", 'uses' => "ProductController@addProduct"]);
    Route::post('submitproduct', ['as' => "submitproduct", 'uses' => "ProductController@submitProduct"]);
    Route::get('getbranch/{id}', ['as' => "getbranch", 'uses' => "ProductController@getBranch"]);
    Route::get('deleteproduct/{id}', ['as' => "deleteproduct", 'uses' => "ProductController@deleteProduct"]);
    Route::get('editproduct/{id}', ['as' => "editproduct", 'uses' => "ProductController@editProduct"]);
    Route::post('editproduct/{id}', ['as' => 'product-update','uses' => 'ProductController@updateProduct']);

    /*=======================================================================================
                                        Product profile start
   ===========================================================================================*/
    //application
    Route::get('product/applications/{id}', ['as' => "applications-product", 'uses' => "ProductController@applicationsProduct"]);
    
    //document
    Route::get('product/document/{id}', ['as' => "document-product", 'uses' => "ProductController@documentProduct"]);
    
    //fees
    Route::get('product/fees/{id}', ['as' => "fees-product", 'uses' => "ProductController@feesProduct"]);
    Route::post('product/productfees/{id}', ['as' => "product-fees", 'uses' => "ProductController@productFees"]);
    Route::get('product/deletefees/{id}', ['as' => "deletefees", 'uses' => "ProductController@productFeesDelete"]);
    Route::get('product/editfees/{id}', ['as' => "editfees", 'uses' => "ProductController@renderEdits"]);
    Route::post('product/productfeesupdate/{id}', ['as' => "product-update", 'uses' => "ProductController@productFeesUpdate"]);
    
    
    
    
    Route::get('typesto', ['as' => "typesto", 'uses' => "ProductController@typesto"]);
    
    //requirement
    Route::get('product/requirement/{id}', ['as' => "requirement-product", 'uses' => "ProductController@requirementProduct"]);
    
    //otherinformation
    Route::get('product/otherinformation/{id}', ['as' => "otherinformation-product", 'uses' => "ProductController@otherinformationProduct"]);
    
    //promotion
    Route::get('product/promotion/{id}', ['as' => "promotion-product", 'uses' => "ProductController@promotionProduct"]);
    
    Route::post('product-promotion-create', ['as' => 'addproduct-promotion','uses' => 'ProductController@productPromotionCreate']);
    Route::post('product-promotion-edit', ['as' => 'editproduct-promotion','uses' => 'ProductController@productPromotionEdit']);
    Route::post('product-promotion-update', ['as' => 'updateproduct-promotion','uses' => 'ProductController@productPromotionUpdate']);
    Route::post('product-promotion-view', ['as' => 'viewproduct-promotion','uses' => 'ProductController@productPromotionView']);
    Route::get('product-promotion-delete{id}/{partner_id}', ['as' => 'deleteproduct-promotion','uses' => 'ProductController@productPromotionDelete']);

    //productdoc
    Route::post('product/productdoc/{id}', ['as' => "productdoc-product", 'uses' => "ProductController@productdocProduct"]);
    Route::get('product/productdocdelete/{id}', ['as' => "productdoc-delete", 'uses' => "ProductController@productdocDeleteProduct"]);

    /*=======================================================================================
                                    Product profile end
    ===========================================================================================*/

    
    /*==========================================================================================
                                Settings
    ===========================================================================================*/
    //prefarance
    Route::get('setting/prefarance/profile', ['as' => "company-profile", 'uses' => "SettingsController@companyProfile"]);
    Route::post('setting/company/profile/update', ['as' => "update-company-profile", 'uses' => "SettingsController@updateCompanyProfile"]);
    
    Route::get('setting/preference/information', ['as' => "domain-information", 'uses' => "SettingsController@domainInformation"]);
    Route::get('setting/preference/legal', ['as' => "preference-legal", 'uses' => "SettingsController@preferenceLegal"]);


    //tag_management
    Route::get('setting/tag/management', ['as' => "tag-management", 'uses' => "SettingsController@tagManagement"]);
    Route::post('setting/tag/management/create', ['as' => "tag-management-create", 'uses' => "SettingsController@tagManagementCreate"]);
    Route::get('setting/tag/management/edit', ['as' => "tag-management-edit", 'uses' => "SettingsController@tagManagementEdit"]);
    Route::post('setting/tag/management/update', ['as' => "tag-management-update", 'uses' => "SettingsController@tagManagementUpdate"]);
    Route::get('setting/tag/management/delete/{id}', ['as' => "tag-management-delete", 'uses' => "SettingsController@tagManagementDelete"]);
    
    //subscription
    Route::get('setting/subscription', ['as' => "setting-subscription", 'uses' => "SettingsController@settingSubscription"]);
    Route::get('setting/subscription/change', ['as' => "subscription-change", 'uses' => "SettingsController@subscriptionChange"]);
    Route::get('setting/subscription/billing', ['as' => "subscription-billing", 'uses' => "SettingsController@subscriptionBilling"]);
    
    Route::post('setting/subscription/review', ['as' => "subscription-billing-review", 'uses' => "SettingsController@subscriptionBillingReview"]);
    Route::post('setting/subscription/save/review', ['as' => "subscription-billing-save-review", 'uses' => "SettingsController@subscriptionBillingSaveReview"]);
    
    //account
    Route::get('setting/account', ['as' => "setting-account", 'uses' => "SettingsController@settingAccount"]);
    Route::get('setting/account/registration/save', ['as' => "update-registration-number", 'uses' => "SettingsController@settingRegistrationSave"]);
    Route::post('setting/account/invoice/update', ['as' => "update-invoice-address", 'uses' => "SettingsController@updateInvoiceAddress"]);
   
    Route::post('setting/account/payment/create', ['as' => "manual-payment-create", 'uses' => "SettingsController@manualPaymentCreate"]);
    Route::get('setting/account/payment/edit', ['as' => "manual-payment-edit", 'uses' => "SettingsController@manualPaymentEdit"]);
    Route::post('setting/account/payment/update', ['as' => "manual-payment-update", 'uses' => "SettingsController@manualPaymentUpdate"]);
    Route::get('setting/account/payment/delete/{id}', ['as' => "manual-payment-delete", 'uses' => "SettingsController@manualPaymentDelete"]);
    
    Route::post('setting/account/tax/update', ['as' => "tax-setting-update", 'uses' => "SettingsController@taxSettingUpdate"]);
    Route::get('setting/account/tax/delete/{id}', ['as' => "tax-setting-delete", 'uses' => "SettingsController@taxSettingDelete"]);
    
    //workflow
    Route::get('setting/workflow', ['as' => "setting-workflow", 'uses' => "SettingsController@settingWorkflow"]);
    Route::get('setting/workflow/add', ['as' => "add-workflow", 'uses' => "SettingsController@addworkflow"]);
    Route::post('setting/workflow/save', ['as' => "save-workflow", 'uses' => "SettingsController@saveWorkflow"]);
    Route::get('setting/workflow/edit/{id}', ['as' => "edit-setting-workflow", 'uses' => "SettingsController@editSettingWorkflow"]);
    Route::post('setting/workflow/update', ['as' => "update-setting-workflow", 'uses' => "SettingsController@updateSettingWorkflow"]);
    Route::get('setting/workflow/delete/{id}', ['as' => "delete-setting-workflow", 'uses' => "SettingsController@deleteSettingWorkflow"]);
    
    Route::get('setting/workflow/delete/stage/{id}/{workflow_id}', ['as' => "delete-setting-workflow-stage", 'uses' => "SettingsController@deleteSettingWorkflowStage"]);
    
    //Document Checklist
    Route::get('setting/document/checklist', ['as' => "setting-document-checklist", 'uses' => "SettingsController@settingDocumentChecklist"]);
    Route::get('setting/document/checklist/add', ['as' => "setting-document-checklist-add", 'uses' => "SettingsController@settingDocumentChecklistAdd"]);
    Route::post('setting/document/checklist/save', ['as' => "setting-document-checklist-save", 'uses' => "SettingsController@settingDocumentChecklistSave"]);
    Route::get('setting/document/checklist/edit/{id}', ['as' => "setting-document-checklist-edit", 'uses' => "SettingsController@settingDocumentChecklistEdit"]);
    Route::post('setting/document/checklist/update', ['as' => "setting-document-checklist-update", 'uses' => "SettingsController@settingDocumentChecklistUpdate"]);
    Route::get('setting/document/checklist/delete/{id}', ['as' => "setting-document-checklist-delete", 'uses' => "SettingsController@settingDocumentChecklistDelete"]);

    //Document Total Checklist
    Route::post('setting-document-total-checklist-create', ['as' => "setting-document-total-checklist-create", 'uses' => "SettingsController@settingDocumentTotalCheckCreate"]);
    Route::get('setting-document-total-checklist-edit', ['as' => "setting-document-total-checklist-edit", 'uses' => "SettingsController@settingDocumentTotalCheckEdit"]);
    Route::post('setting-document-total-checklist-update', ['as' => "setting-document-total-checklist-update", 'uses' => "SettingsController@settingDocumentTotalCheckUpdate"]);

    Route::get('setting/document/total/checklist/delete/{id}/{checklist_id}', ['as' => "setting-document-total-checklist-delete", 'uses' => "SettingsController@settingDocumentTotalCheckDelete"]);
    
    Route::get('related-partner-product-info', ['as' => "related-partner-product-info", 'uses' => "SettingsController@relatedPartnerProductInfo"]);

    //Document Type
    Route::get('setting/document/type', ['as' => "setting-document-type", 'uses' => "SettingsController@settingDocumentType"]);
    Route::post('setting-document-type-create', ['as' => "setting-document-type-create", 'uses' => "SettingsController@settingDocumentTypeCreate"]);
    Route::get('setting-document-type-edit', ['as' => "setting-document-type-edit", 'uses' => "SettingsController@settingDocumentTypeEdit"]);
    Route::post('setting-document-type-update', ['as' => "setting-document-type-update", 'uses' => "SettingsController@settingDocumentTypeUpdate"]);
    Route::get('setting-document-type-delete/{id}', ['as' => "setting-document-type-delete", 'uses' => "SettingsController@settingDocumentTypeDelete"]);
    
    //email
    Route::get('setting/email', ['as' => "setting-email", 'uses' => "SettingsController@settingEmail"]);

    Route::post('setting-email-create', ['as' => "setting-email-create", 'uses' => "SettingsController@settingEmailCreate"]);
    Route::get('setting-email-edit', ['as' => "setting-email-edit", 'uses' => "SettingsController@settingEmailEdit"]);
    Route::post('setting-email-update', ['as' => "setting-email-update", 'uses' => "SettingsController@settingEmailUpdate"]);
    Route::get('setting-email-delete/{id}', ['as' => "setting-email-delete", 'uses' => "SettingsController@settingEmailDelete"]);

    Route::get('setting-email-active/{id}', ['as' => "setting-email-active", 'uses' => "SettingsController@settingEmailActive"]);
    Route::get('setting-email-deactive/{id}', ['as' => "setting-email-deactive", 'uses' => "SettingsController@settingEmailDeactive"]);
    
    //templates
    Route::get('setting/template/sms', ['as' => "setting-template-sms", 'uses' => "SettingsController@settingTemplatesSms"]);
    Route::get('setting/template/email', ['as' => "setting-template-email", 'uses' => "SettingsController@settingTemplate"]);
    
    Route::get('setting/template/sms', ['as' => "setting-template-sms", 'uses' => "SettingsController@settingTemplatesSms"]);
    Route::get('setting/template/email', ['as' => "setting-template-email", 'uses' => "SettingsController@settingTemplate"]);

    Route::post('template-email-create', ['as' => "template-email-create", 'uses' => "SettingsController@templateEmailCreate"]);
    Route::get('template-email-edit', ['as' => "template-email-edit", 'uses' => "SettingsController@templateEmailEdit"]);
    Route::post('template-email-update', ['as' => "template-email-update", 'uses' => "SettingsController@templateEmailUpdate"]);
    Route::get('template-email-delete/{id}', ['as' => "template-email-delete", 'uses' => "SettingsController@templateEmailDelete"]);
    
    Route::post('template-sms-create', ['as' => "template-sms-create", 'uses' => "SettingsController@templateSmsCreate"]);
    Route::get('template-sms-edit', ['as' => "template-sms-edit", 'uses' => "SettingsController@templateSmsEdit"]);
    Route::post('template-sms-update', ['as' => "template-sms-update", 'uses' => "SettingsController@templateSmsUpdate"]);
    Route::get('template-sms-delete/{id}', ['as' => "template-sms-delete", 'uses' => "SettingsController@templateSmsDelete"]);
    
    //phonesetting
    Route::get('setting/phone/number', ['as' => "phone-setting", 'uses' => "SettingsController@phoneSetting"]);
    Route::get('setting/credit/balance', ['as' => "credit-balance", 'uses' => "SettingsController@creditBalance"]);
    Route::get('setting/phone/log', ['as' => "phone-setting-log", 'uses' => "SettingsController@phoneSettinglog"]);
    Route::get('setting/regulatory/compliance', ['as' => "regulatory-compliance", 'uses' => "SettingsController@regulatoryCompliance"]);
    

    //setting_leadform
    Route::get('setting/leadform', ['as' => "setting-lead-form", 'uses' => "SettingsController@settingLeadform"]);
    Route::get('setting/leadform/create', ['as' => "setting-leadform-create", 'uses' => "SettingsController@settingLeadformCreate"]);
    Route::post('setting/leadform/save', ['as' => "setting-leadform-save", 'uses' => "SettingsController@settingLeadformSave"]);
    Route::get('setting/leadform/edit/{id}', ['as' => "setting-leadform-edit", 'uses' => "SettingsController@settingLeadformEdit"]);
    Route::post('setting/leadform/update', ['as' => "setting-leadform-update", 'uses' => "SettingsController@settingLeadformUpdate"]);
    Route::get('setting/leadform/set/favourite/{id}/{status_id}', ['as' => "leadform-set-favourite", 'uses' => "SettingsController@leadform_set_favourite"]);
    Route::get('setting/leadform/status/{id}/{status_id}', ['as' => "leadform-active-deactive", 'uses' => "SettingsController@leadform_active_deactive"]);
    
    //setting_automation
    Route::get('setting/automation', ['as' => "setting-automation", 'uses' => "SettingsController@settingAutomation"]);
    
    Route::post('setting-automation-create', ['as' => "setting-automation-create", 'uses' => "SettingsController@settingAutomationCreate"]);
    Route::get('setting-automation-edit', ['as' => "setting-automation-edit", 'uses' => "SettingsController@settingAutomationEdit"]);
    Route::post('setting-automation-update', ['as' => "setting-automation-update", 'uses' => "SettingsController@settingAutomationUpdate"]);
    Route::get('setting-automation-delete/{id}', ['as' => "setting-automation-delete", 'uses' => "SettingsController@settingAutomationDelete"]);
    
    //customfield_client
    Route::get('setting/customfield/client', ['as' => "customfield-client", 'uses' => "SettingsController@customfieldClient"]);
    Route::get('setting/customfield/partner', ['as' => "customfield-partner", 'uses' => "SettingsController@customfieldPartner"]);
    Route::get('setting/customfield/product', ['as' => "customfield-product", 'uses' => "SettingsController@customfieldProduct"]);
    Route::get('setting/customfield/application', ['as' => "customfield-application", 'uses' => "SettingsController@customfieldApplication"]);
    
    Route::post('setting-customfield-add', ['as' => "setting-customfield-add", 'uses' => "SettingsController@settingCustomfieldAdd"]);
    Route::get('setting-customfield-edit', ['as' => "setting-customfield-edit", 'uses' => "SettingsController@settingCustomfieldEdit"]);
    Route::post('setting-customfield-update', ['as' => "setting-customfield-update", 'uses' => "SettingsController@settingCustomfieldUpdate"]);
    Route::get('setting-customfield-delete/{id}/{module_id}', ['as' => "setting-customfield-delete", 'uses' => "SettingsController@settingCustomfieldDelete"]);
    
    //setting_general
    Route::get('setting/general/partnerproduct', ['as' => "pp-type-list", 'uses' => "SettingsController@manageProductPartner"]);
    Route::post('setting/general/partnerproduct/add', ['as' => "pp-type-add", 'uses' => "SettingsController@addProductPartner"]);
    Route::get('setting/general/partner/edit/{id}', ['as' => 'partner-edit','uses' => 'SettingsController@editPartner']);
    Route::post('setting/general/partner/update', ['as' => 'partner-update','uses' => 'SettingsController@updatePartner']);
    Route::get('setting/general/product/edit/{id}', ['as' => 'product-edit','uses' => 'SettingsController@editProduct']);
    Route::post('setting/general/product/update', ['as' => 'product-update','uses' => 'SettingsController@updateProduct']);
    Route::get('setting/general/product/delete/{id}', ['as' => 'product-delete','uses' => 'SettingsController@deleteProduct']);
    Route::get('setting/general/partner/delete/{id}', ['as' => 'partner-delete','uses' => 'SettingsController@deletePartner']);
    
    Route::get('setting/general/discontinued', ['as' => "general-discontinued", 'uses' => "SettingsController@generalDiscontinued"]);
    Route::post('setting/general/discontinued/update', ['as' => "update-discontinue-reason", 'uses' => "SettingsController@updateDiscontinueReason"]);
    Route::get('setting/general/discontinued/delete/{id}', ['as' => "delete-discontinue-reason", 'uses' => "SettingsController@deleteDiscontinueReason"]);
    
    Route::get('setting/general/others', ['as' => "setting-general-others", 'uses' => "SettingsController@settingGeneralOther"]);
    Route::post('setting/general/others/update', ['as' => "update-general-others", 'uses' => "SettingsController@updateGeneralOther"]);
    Route::get('setting/general/others/delete/{id}', ['as' => "delete-general-others", 'uses' => "SettingsController@deleteGeneralOther"]);
    
    //dataimport_contact
    Route::get('setting/dataimport/partnerproduct', ['as' => "dataimport-partner-product", 'uses' => "SettingsController@dataimportPartnerproduct"]);
    Route::get('setting/dataimport/contact', ['as' => "dataimport-contact", 'uses' => "SettingsController@dataimportContact"]);
    Route::get('setting/dataimport/application', ['as' => "dataimport-application", 'uses' => "SettingsController@dataimportApplication"]);
    
    //setting_officecheckin
    Route::get('setting/office/checkin/{id}', ['as' => "setting-office-checkin", 'uses' => "SettingsController@settingOfficecheckin"]);
    Route::get('setting/office/checkin', ['as' => "setting-office-checkin", 'uses' => "SettingsController@settingOfficecheckin"]);
    Route::post('setting/office/checkin/update/', ['as' => "setting-office-checkin-update", 'uses' => "SettingsController@settingOfficeCheckinUpdate"]);
    
    
    /*==========================================================================================
                                Settings end
    ===========================================================================================*/
    
    //active agents
    Route::get('agents/active/list/', ['as' => 'agent-active-list','uses' => 'AgentController@agentActiveList']);
    Route::get('agents/add/', ['as' => 'agent-add','uses' => 'AgentController@agentAdd']);
    Route::post('agents/save/', ['as' => 'agent-save','uses' => 'AgentController@agentSave']);
    Route::get('agents/edit/{id}/', ['as' => 'agent-edit','uses' => 'AgentController@agentEdit']);
    Route::post('agents/update/', ['as' => 'agent-update','uses' => 'AgentController@agentUpdate']);
    
    //inactive agents
    Route::get('agents/inactive/list/', ['as' => 'agent-inactive-list','uses' => 'AgentController@agentInactiveList']);

    Route::get('agents/active/{id}', ['as' => 'agent-active','uses' => 'AgentController@agentActive']);
    Route::get('agents/inactive/{id}', ['as' => 'agent-inactive','uses' => 'AgentController@agentInactive']);
    
    //task
    Route::get('task/list', ['as' => 'list-task','uses' => 'TaskController@taskList']);
    Route::post('task/create', ['as' => 'add-task','uses' => 'TaskController@taskCreate']);
    Route::post('task/edit', ['as' => 'edit-task','uses' => 'TaskController@taskEdit']);
    Route::post('task/update', ['as' => 'update-task','uses' => 'TaskController@taskUpdate']);
    Route::get('task/delete/{id}', ['as' => 'delete-task','uses' => 'TaskController@taskDelete']);

    Route::get('client-application-info', ['as' => 'client-application-info','uses' => 'TaskController@clientApplicationInfo']);
    
     //Report----------------------
    Route::get('report/client', ['as' => 'report_client','uses' => 'ReportController@report_client']);
    Route::get('all/report/client', ['as' => 'get_report_client','uses' => 'ReportController@get_report_client']);
    Route::get('get_single_client', ['as' => 'get_single_client','uses' => 'ReportController@get_single_client']);
    Route::post('send_client_email', ['as' => 'send_client_email','uses' => 'ReportController@send_client_email']);
    Route::get('report/application', ['as' => 'report_application','uses' => 'ReportController@report_application']);
    Route::get('get_report_application', ['as' => 'get_report_application','uses' => 'ReportController@get_report_application']);
    Route::get('report_invoice', ['as' => 'report_invoice','uses' => 'ReportController@report_invoice']);
    Route::get('report/personaltask', ['as' => 'report_personaltask','uses' => 'ReportController@report_personaltask']);
    
    /*
     *
     *  Settings Routes
     *
     * ---------------------------------------------------------------------
     */
    Route::group(['middleware' => ['permission:edit_settings']], function () {
        $module_name = 'settings';
        $controller_name = 'SettingController';
        Route::get("$module_name", "$controller_name@index")->name("$module_name");
        Route::post("$module_name", "$controller_name@store")->name("$module_name.store");
    });

    /*
    *
    *  Notification Routes
    *
    * ---------------------------------------------------------------------
    */
    $module_name = 'notifications';
    $controller_name = 'NotificationsController';
    Route::get("$module_name", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    Route::get("$module_name/markAllAsRead", ['as' => "$module_name.markAllAsRead", 'uses' => "$controller_name@markAllAsRead"]);
    Route::delete("$module_name/deleteAll", ['as' => "$module_name.deleteAll", 'uses' => "$controller_name@deleteAll"]);
    Route::get("$module_name/{id}", ['as' => "$module_name.show", 'uses' => "$controller_name@show"]);

    /*
    *
    *  Backup Routes
    *
    * ---------------------------------------------------------------------
    */
    $module_name = 'backups';
    $controller_name = 'BackupController';
    Route::get("$module_name", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    Route::get("$module_name/create", ['as' => "$module_name.create", 'uses' => "$controller_name@create"]);
    Route::get("$module_name/download/{file_name}", ['as' => "$module_name.download", 'uses' => "$controller_name@download"]);
    Route::get("$module_name/delete/{file_name}", ['as' => "$module_name.delete", 'uses' => "$controller_name@delete"]);

    /*
    *
    *  Roles Routes
    *
    * ---------------------------------------------------------------------
    */
    $module_name = 'roles';
    $controller_name = 'RolesController';
    Route::resource("$module_name", "$controller_name");

    /*
    *
    *  Users Routes
    *
    * ---------------------------------------------------------------------
    */
    $module_name = 'users';
    $controller_name = 'UserController';
    Route::get("$module_name/profile/{id}", ['as' => "$module_name.profile", 'uses' => "$controller_name@profile"]);
    Route::get("$module_name/profile/{id}/edit", ['as' => "$module_name.profileEdit", 'uses' => "$controller_name@profileEdit"]);
    Route::patch("$module_name/profile/{id}/edit", ['as' => "$module_name.profileUpdate", 'uses' => "$controller_name@profileUpdate"]);
    Route::get("$module_name/emailConfirmationResend/{id}", ['as' => "$module_name.emailConfirmationResend", 'uses' => "$controller_name@emailConfirmationResend"]);
    Route::delete("$module_name/userProviderDestroy", ['as' => "$module_name.userProviderDestroy", 'uses' => "$controller_name@userProviderDestroy"]);
    Route::get("$module_name/profile/changeProfilePassword/{id}", ['as' => "$module_name.changeProfilePassword", 'uses' => "$controller_name@changeProfilePassword"]);
    Route::patch("$module_name/profile/changeProfilePassword/{id}", ['as' => "$module_name.changeProfilePasswordUpdate", 'uses' => "$controller_name@changeProfilePasswordUpdate"]);
    Route::get("$module_name/changePassword/{id}", ['as' => "$module_name.changePassword", 'uses' => "$controller_name@changePassword"]);
    Route::patch("$module_name/changePassword/{id}", ['as' => "$module_name.changePasswordUpdate", 'uses' => "$controller_name@changePasswordUpdate"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::resource("$module_name", "$controller_name");
    Route::patch("$module_name/{id}/block", ['as' => "$module_name.block", 'uses' => "$controller_name@block", 'middleware' => ['permission:block_users']]);
    Route::patch("$module_name/{id}/unblock", ['as' => "$module_name.unblock", 'uses' => "$controller_name@unblock", 'middleware' => ['permission:block_users']]);

});

Route::group(['namespace' => 'Api', 'prefix' => 'admin', 'as' => 'backend.'], function () {
    //subscription & stripe & paypal
    Route::get('stripe/{id}', ['as' => "stripe", 'uses' => "StripePaymentController@stripe"]);
    Route::post('stripe', ['as' => "stripe.post", 'uses' => "StripePaymentController@stripePost"]);
    
    Route::get('paypal/{id}', 'PayPalPaymentController@paypal')->name('paypal');

    Route::get('payment', 'PayPalPaymentController@payment')->name('payment');
    Route::get('cancel', 'PayPalPaymentController@cancel')->name('payment.cancel');
    Route::get('payment/success', 'PayPalPaymentController@success')->name('payment.success');
    
});

