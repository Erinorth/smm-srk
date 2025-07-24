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

Route::get('/', function () {
    return view('welcome');
});

//Auth
Auth::routes(['verify' => true]);
//Auth::routes();

//dashboard
Route::get('/dashboard_cost','DashboardController@cost');
Route::get('/dashboard_duration','DashboardController@duration');
Route::get('/dashboard_dailyreport','DashboardController@dailyreport');
Route::get('/dashboard_dailyreport_outside','DashboardController@dailyreportoutside');
Route::get('/dashboard_expensive_tool','DashboardController@tooltimeconfirm');
Route::get('/dashboard_overtime','DashboardController@overtime');
Route::get('/dashboard_quality','DashboardController@quality');
Route::get('/dashboard_safety','DashboardController@safety');
Route::get('/dashboard_tooltimeconfirm','DashboardController@tooltimeconfirm');

Route::post('/dashboard/accident','DashboardController@accident');
Route::post('/dashboard/checkup','DashboardController@checkup');
Route::post('/dashboard/environment','DashboardController@environment');
Route::post('/dashboard/di','DashboardController@di');
Route::post('/dashboard/illness','DashboardController@illness');
Route::get('/dashboard/project','DashboardController@project');
Route::post('/dashboard/project2','DashboardController@project2');
Route::post('/dashboard/totalloss','DashboardController@totalloss');

//date
Route::get('/adddate','DateController@adddate');
Route::get('/dumpdate','DateController@dumpdate');

//home
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home','HomeController@index')->name('home')->middleware('auth');
Route::get('/dashboard','HomeController@dashboard')->name('dashboard')->middleware('auth');

//project
Route::get('/projects','ProjectController@index');
Route::get('/projects/prepare','ProjectController@prepare');
Route::get('/projects/inprogress','ProjectController@inprogress');
Route::get('/projects/finish','ProjectController@finish');

//mail
Route::get('/mail_certificate','MailController@certificate');
Route::get('/mail_facility','MailController@facility');
Route::get('/mail_finishproject','MailController@finishproject');
Route::get('/mail_milestone','MailController@milestone');
Route::get('/mail_overtime','MailController@overtime');
Route::get('/mail_plan','MailController@plan');
Route::get('/mail_pmorder','MailController@pmorder');
Route::get('/mail_request_man','MailController@request_man');
Route::get('/mail_tool_calibrate','MailController@tool_calibrate');
Route::get('/mail_tool_pm','MailController@tool_pm');

Route::get('mail_responsible','MailController@responsible');
Route::post('mail_responsible','MailController@responsiblestore');
Route::get('mail_responsible/{id}/edit','MailController@responsibleedit');
Route::post('mail_responsible/update','MailController@responsibleupdate');

Route::middleware('auth')->group(function () {
    //activity
    Route::get('/activity_standards','ActivityController@standard');
    Route::post('/activity_standards','ActivityController@standardstore');
    Route::get('/activity_standards/{id}/edit','ActivityController@standardedit');
    Route::post('/activity_standards/update','ActivityController@standardupdate');
    Route::get('/activity_standards/destroy/{id}','ActivityController@standarddestroy');

    Route::get('/item_activities/{id}','ActivityController@item');
    Route::post('/item_activities','ActivityController@itemstore');
    Route::get('/item_activities/{id}/edit','ActivityController@itemedit');
    Route::post('/item_activities/update','ActivityController@itemupdate');
    Route::get('/item_activities/destroy/{id}','ActivityController@itemdestroy');

    Route::post('/item_activity_standards','ActivityController@itemstandardstore');

    Route::get('/activity_projects/{id}','ActivityController@project');

    Route::get('/activity_amounts/{id}','ActivityController@amount');

    //action plan
    Route::get('actionplans/{meetingid}/create','ActionPlanController@create');
    Route::post('actionplans','ActionPlanController@store');
    Route::get('actionplans/{actionplanid}/edit','ActionPlanController@edit');
    Route::put('actionplans/{actionplanid}','ActionPlanController@update');
    Route::delete('actionplans/{actionplanid}','ActionPlanController@destroy');

    //check data
    Route::get('/checkall/{id}','CheckDataController@show');

    //check list
    Route::get('/checklists/{jobid}/{itemid}','CheckListController@show');

    //confined space
    Route::get('/confinedspaces/{id}','ConfinedSpaceController@create');
    Route::post('/confinedspaces','ConfinedSpaceController@store');
    Route::get('/confinedspaces/{id}/edit','ConfinedSpaceController@edit');
    Route::post('/confinedspaces/update','ConfinedSpaceController@update');
    Route::get('/confinedspaces/destroy/{id}','ConfinedSpaceController@destroy');

    //consumable
    Route::resource('/consumables','ConsumableController');
    Route::post('consumables/update', 'ConsumableController@update')->name('consumable.update');
    Route::get('consumables/destroy/{id}','ConsumableController@destroy');

    Route::get('/item_consumables/{id}','ConsumableController@item');
    Route::post('/item_consumables','ConsumableController@itemstore');
    Route::get('/item_consumables/{id}/edit','ConsumableController@itemedit');
    Route::post('/item_consumables/update','ConsumableController@itemupdate');
    Route::get('/item_consumables/destroy/{id}','ConsumableController@itemdestroy');

    Route::get('/consumable_addstores','ConsumableController@storeadd');
    Route::post('/consumable_addstores','ConsumableController@storeaddstore');
    Route::get('/consumable_addstores/{id}/edit','ConsumableController@storeaddedit');
    Route::post('/consumable_addstores/update','ConsumableController@storeaddupdate');
    Route::get('/consumable_addstores/destroy/{id}','ConsumableController@storeadddestroy');

    Route::get('/consumable_picks/{id}/pmorder','ConsumableController@pmorder');
    Route::get('/consumable_picks/{id}','ConsumableController@sitepick');
    Route::post('/consumable_picks','ConsumableController@sitepickstore');
    Route::get('/consumable_picks/{id}/edit','ConsumableController@sitepickedit');
    Route::post('/consumable_picks/update','ConsumableController@sitepickupdate')->name('consumablepick.update');;
    Route::get('/consumable_picks/destroy/{id}','ConsumableController@sitepickdestroy');

    Route::get('/consumable_confirms/{id}','ConsumableController@siteconfirm');
    Route::post('/consumable_confirms/update','ConsumableController@siteconfirmupdate');

    Route::get('/consumable_returns/{id}','ConsumableController@sitereturn');
    Route::get('/consumable_returns/{id}/edit','ConsumableController@sitereturnedit');
    Route::post('/consumable_returns/update','ConsumableController@sitereturnupdate');

    Route::get('/consumable_projects/{id}','ConsumableController@project');

    Route::get('/consumable_amounts/{id}','ConsumableController@amount');

    //control graph
    Route::get('/safety_health_control','ControlGraphController@safety_health');
    Route::post('/safety_health_control','ControlGraphController@safety_healthstore');
    Route::get('/safety_health_control/{id}/edit','ControlGraphController@safety_healthedit');
    Route::post('/safety_health_control/update','ControlGraphController@safety_healthupdate');
    Route::get('/safety_health_control/destroy/{id}','ControlGraphController@safety_healthdestroy');

    //cost rate
    Route::resource('/costrates','CostRateController');

    //craft
    Route::resource('/crafts','CraftController');

    //crane certificate
    Route::get('/crane_certificate','CraneCertificateController@index');
    Route::post('/crane_certificate','CraneCertificateController@store');
    Route::get('/crane_certificate/{id}/edit','CraneCertificateController@edit');
    Route::post('/crane_certificate/update','CraneCertificateController@update');
    Route::post('/crane_certificate/change','CraneCertificateController@change');
    Route::get('/crane_certificate/destroy/{id}','CraneCertificateController@destroy');

    Route::get('/crane_certificate/{id}','CraneCertificateController@project');

    //course
    Route::get('/courses','CourseController@index');
    Route::post('/courses','CourseController@store');
    Route::get('/courses/{id}/edit','CourseController@edit');
    Route::post('/courses/update','CourseController@update');
    Route::get('/courses/destroy/{id}','CourseController@destroy');

    //ddd
    Route::get('ddd','DDDController@index');
    Route::post('ddd/fetch','DDDController@fetch')->name('ddd.fetch');

    //dangerous zone
    Route::get('/dangerouszones/{id}','DangerousZoneController@create');
    Route::post('/dangerouszones','DangerousZoneController@store');
    Route::get('/dangerouszones/{id}/edit','DangerousZoneController@edit');
    Route::post('/dangerouszones/update','DangerousZoneController@update');
    Route::get('/dangerouszones/destroy/{id}','DangerousZoneController@destroy');

    //date_measuring tool
    Route::get('/date_measuringtools','DateMeasuringToolController@index');
    Route::get('/date_measuringtools/{jobdateid}/create','DateMeasuringToolController@create');
    Route::post('/date_measuringtools/{jobdateid}','DateMeasuringToolController@store');
    Route::get('/date_measuringtools/{datemeasuringtoolid}/edit','DateMeasuringToolController@edit');
    Route::put('/date_measuringtools/{datemeasuringtoolid}','DateMeasuringToolController@update');
    Route::delete('/date_measuringtools/{datemeasuringtoolid}','DateMeasuringToolController@destroy');

    //document
    Route::get('/documents/{id}','DocumentController@create');
    Route::post('/documents','DocumentController@store');
    Route::get('/documents/{id}/edit','DocumentController@edit');
    Route::post('/documents/update','DocumentController@update');
    Route::post('/documents/change','DocumentController@change');
    Route::get('documents/destroy/{id}','DocumentController@destroy');

    Route::get('/document_projects/{id}','DocumentController@project');

    Route::get('/document_amounts/{id}','DocumentController@amount');

    //drone
    Route::get('/drones/{id}','DroneController@create');
    Route::post('/drones','DroneController@store');
    Route::get('/drones/{id}/edit','DroneController@edit');
    Route::post('/drones/update','DroneController@update');
    Route::get('/drones/destroy/{id}','DroneController@destroy');

    //employee
    Route::get('/employees','EmployeeController@index');
    Route::post('/employees','EmployeeController@store');
    Route::get('/employees/{id}/edit','EmployeeController@edit');
    Route::post('/employees/update','EmployeeController@update');
    Route::get('/employees/destroy/{id}','EmployeeController@destroy');

    Route::get('/employee_details','EmployeeController@detail');

    Route::get('/employees_certificate','EmployeeController@certificate');
    Route::post('/employees_certificate','EmployeeController@certificatestore');
    Route::get('/employees_certificate/{id}/edit','EmployeeController@certificateedit');
    Route::post('/employees_certificate/update','EmployeeController@certificateupdate');
    Route::get('/employees_certificate/destroy/{id}/{employeeid}/{certificatetypeid}','EmployeeController@certificatedestroy');

    Route::get('/employees_certificate_project/{id}','EmployeeController@certificateproject');

    Route::get('/departments','EmployeeController@department');
    Route::post('/departments','EmployeeController@departmentstore');
    Route::get('/departments/{id}/edit','EmployeeController@departmentedit');
    Route::post('/departments/update','EmployeeController@departmentupdate');
    Route::get('/departments/destroy/{id}','EmployeeController@departmentdestroy');

    //equipment
    Route::get('/equipment','EquipmentController@index');
    Route::post('/equipment','EquipmentController@store');
    Route::get('/equipment/{id}/edit','EquipmentController@edit');
    Route::post('/equipment/update','EquipmentController@update');
    Route::get('/equipment/destroy/{id}','EquipmentController@destroy');

    //facility
    Route::get('/facility_project/{id}','FacilityController@project');

    Route::get('/facility_project_crane/{id}','FacilityController@projectcrane');
    Route::post('/facility_project_crane','FacilityController@projectcranestore');
    Route::get('/facility_project_crane/{id}/edit','FacilityController@projectcraneedit');
    Route::post('/facility_project_crane/update','FacilityController@projectcraneupdate');
    Route::get('/facility_project_crane/destroy/{id}','FacilityController@projectcranedestroy');

    Route::get('/facility_project_tool/{id}','FacilityController@projecttool');
    Route::post('/facility_project_tool','FacilityController@projecttoolstore');
    Route::get('/facility_project_tool/{id}/edit','FacilityController@projecttooledit');
    Route::post('/facility_project_tool/update','FacilityController@projecttoolupdate');
    Route::get('/facility_project_tool/destroy/{id}','FacilityController@projecttooldestroy');
    Route::post('/facility_project_tool_attachment','FacilityController@projecttoolattachment');
    Route::post('/facility_project_tool_attachment/update','FacilityController@projecttoolattachmentupdate');
    Route::get('/facility_project_tool_attachment/destroy/{id}/{projectid}','FacilityController@projecttoolattachmentdelete');

    //factor
    Route::get('/factors','FactorController@index');
    Route::post('/factors','FactorController@store');
    Route::get('/factors/{id}/edit','FactorController@edit');
    Route::post('/factors/update','FactorController@update');
    Route::get('/factors/destroy/{id}','FactorController@destroy');

    //hazard
    Route::get('/hazards','HazardController@index');
    Route::post('/hazards','HazardController@store');
    Route::get('/hazards/{id}/edit','HazardController@edit');
    Route::post('/hazards/update','HazardController@update');
    Route::get('/hazards/destroy/{id}','HazardController@destroy');
    Route::get('/hazard_controls/{id}','HazardController@controlcreate');
    Route::post('/hazard_controls','HazardController@controlstore');
    Route::get('/hazard_controls/{id}/edit','HazardController@controledit');
    Route::post('/hazard_controls/update','HazardController@controlupdate');
    Route::get('/hazard_controls/destroy/{id}','HazardController@controldestroy');
    Route::get('/item_hazards/{id}','HazardController@item');
    Route::post('/item_hazards','HazardController@itemstore');
    Route::get('/item_hazards/{id}/edit','HazardController@itemedit');
    Route::post('/item_hazards/update','HazardController@itemupdate');
    Route::get('/item_hazards/destroy/{id}','HazardController@itemdestroy');

    Route::get('/hazard_projects/{id}','HazardController@project');

    Route::get('/hazard_amounts/{id}','HazardController@amount');

    //hoist
    Route::get('/hoist/{id}','HoistController@project');
    Route::post('/hoist','HoistController@projectstore');
    Route::get('/hoist/{id}/edit','HoistController@projectedit');
    Route::post('/hoist/update','HoistController@projectupdate');
    Route::get('hoist/destroy/{id}','HoistController@projectdestroy');

    Route::get('/hoist_list','HoistController@list');
    Route::post('/hoist_list','HoistController@liststore');
    Route::get('/hoist_list/{id}/{type}','HoistController@listshow');
    Route::get('/hoist_lists/{id}/edit','HoistController@listedit');
    Route::post('/hoist_list/update','HoistController@listupdate');
    Route::get('hoist_list/destroy/{id}','HoistController@listdestroy');

    //hot work
    Route::get('/hotworks/{id}','HotWorkController@create');
    Route::post('/hotworks','HotWorkController@store');
    Route::get('/hotworks/{id}/edit','HotWorkController@edit');
    Route::post('/hotworks/update','HotWorkController@update');
    Route::get('/hotworks/destroy/{id}','HotWorkController@destroy');

    //item
    Route::get('/items','ItemController@index');
    Route::get('/items_select/{id}','ItemController@select');
    Route::post('/items','ItemController@store');
    Route::get('/items/{id}','ItemController@show');
    Route::get('/items/{id}/edit','ItemController@edit');
    Route::post('/items/update','ItemController@update');
    Route::get('/items/destroy/{id}','ItemController@destroy');

    /* Route::post('/item_location_machines','ItemController@locationmachinestore');
    Route::get('/item_location_machines/{id}/edit','ItemController@locationmachineedit');
    Route::post('/item_location_machines/update','ItemController@locationmachineupdate');
    Route::get('/item_location_machines/destroy/{id}','ItemController@locationmachinedestroy'); */

    Route::get('/item_sets','ItemController@set');
    Route::post('/item_sets','ItemController@setstore');
    Route::get('/item_sets/{id}/edit','ItemController@setedit');
    Route::post('/item_sets/update','ItemController@setupdate');
    Route::get('/item_sets/destroy/{id}','ItemController@setdestroy');

    //job
    Route::get('/jobs_location_machine/{id}','JobController@locationmachine');
    Route::get('/jobs_location_machine_select/{id}','JobController@locationmachineselect');
    Route::get('/jobs_create/{project}/{id}','JobController@create');
    Route::get('/job_items/{id}','JobController@itemcreate');
    Route::get('/job_items/{id}/create','JobController@addtojob');
    Route::post('/jobs','JobController@store');
    Route::get('/jobs/{id}','JobController@show');
    Route::get('/jobs/{id}/edit','JobController@edit');
    Route::post('/jobs/update','JobController@update');
    Route::get('/jobs/destroy/{id}','JobController@destroy');
    Route::get('/job_dates/{jobid}/create','JobController@datecreate');
    Route::post('/job_dates','JobController@datestore');
    Route::get('/job_dates/{jobdateid}','JobController@dateshow');
    Route::get('/job_dates/{jobdateid}/edit','JobController@dateedit');
    Route::put('/job_dates/{jobdateid}','JobController@dateupdate');
    Route::delete('job_dates/{jobdateid}','JobController@datedestroy');

    //job_date
    Route::get('/date_expensivetools/{jobdateid}/create','JobDateController@expensivetoolcreate');
    Route::get('/date_expensivetools/{jobdateid}/create','JobDateController@expensivetoolcreate');
    Route::post('/date_expensivetools/{jobdateid}','JobDateController@expensivetoolstore');
    Route::get('/date_expensivetools/{dateexpensivetoolid}/edit','JobDateController@expensivetooledit');
    Route::put('/date_expensivetools/{dateexpensivetoolid}','JobDateController@expensivetoolupdate');
    Route::delete('/date_expensivetools/{dateexpensivetoolid}','JobDateController@expensivetooldestroy');

    //job position
    Route::get('/jobpositions','JobPositionController@index');
    Route::post('/jobpositions','JobPositionController@store');
    Route::get('/jobpositions/{id}/edit','JobPositionController@edit');
    Route::post('/jobpositions/update','JobPositionController@update');
    Route::get('/jobpositions/destroy/{id}','JobPositionController@destroy');

    //knowledge skilled
    Route::get('knowledgeskills/{employeeid}','KnowledgeSkillController@index');

    //kpi
    Route::get('/KPIs','KPIController@index');
    Route::get('/KPIs/{id}/{semiannualid}','KPIController@show');

    Route::post('/KPIs_all','KPIController@all');

    Route::get('/KPIs_individual/{id}','KPIController@individual');

    //law
    Route::get('/laws','LawController@index');
    Route::post('/laws','LawController@store');
    Route::get('/laws/{id}/edit','LawController@edit');
    Route::post('/laws/update','LawController@update');
    Route::get('/laws/destroy/{id}','LawController@destroy');

    Route::get('/law_details/{id}','LawController@detail');
    Route::post('/law_details','LawController@detailstore');
    Route::get('/law_details/{id}/edit','LawController@detailedit');
    Route::post('/law_details/update','LawController@detailupdate');
    Route::get('/law_details/destroy/{id}','LawController@detaildestroy');

    Route::get('/law_assesments','LawController@department');
    Route::get('/law_assesments/{id}','LawController@assesmentlaw');
    Route::get('/law_assesments/{departmentid}/{lawid}','LawController@assesment');
    Route::post('/law_assesments','LawController@assesmentstore');
    Route::get('/law_assesments_evident/{id}/edit','LawController@assesmentedit');
    Route::post('/law_assesments/update','LawController@assesmentupdate');
    Route::post('/law_assesments_related','LawController@related');
    Route::get('/law_assesments/destroy/{id}','LawController@assesmentdestroy');

    //lifting
    Route::get('/liftings/{id}','LiftingController@create');
    Route::post('/liftings','LiftingController@store');
    Route::get('/liftings/{id}/edit','LiftingController@edit');
    Route::post('/liftings/update','LiftingController@update');
    Route::get('/liftings/destroy/{id}','LiftingController@destroy');

    //location
    Route::get('/locations','LocationController@index');
    Route::post('/locations','LocationController@store');
    Route::get('/locations/{id}/edit','LocationController@edit');
    Route::post('/locations/update','LocationController@update');
    Route::get('/locations/destroy/{id}','LocationController@destroy');
    Route::get('/project_locations/{projectid}/create','LocationController@projectcreate');
    Route::post('/project_locations','LocationController@projectstore');
    Route::delete('project_locations/{projectproductid}','LocationController@projectdestroy');

    //machine
    Route::get('/machines','MachineController@index');
    Route::post('/machines','MachineController@store');
    Route::get('/machines/{id}/edit','MachineController@edit');
    Route::post('/machines/update','MachineController@update');
    Route::get('/machines/destroy/{id}','MachineController@destroy');
    Route::get('/product_machines/{locationproductid}/create','MachineController@productcreate');
    Route::post('/product_machines','MachineController@productstore');
    Route::delete('product_machine/{productmachineid}','MachineController@productdestroy');

    Route::get('/machine_sets','MachineController@set');
    Route::post('/machine_sets','MachineController@setstore');
    Route::get('/machine_sets/{id}/edit','MachineController@setedit');
    Route::post('/machine_sets/update','MachineController@setupdate');
    Route::get('/machine_sets/destroy/{id}','MachineController@setdestroy');

    //maintenance report
    Route::get('maintenance_reports/{id}','MRController@create');
    Route::post('maintenance_reports_create','MRController@storecreate');
    Route::post('maintenance_reports','MRController@store');
    Route::get('maintenance_reports/{id}/edit','MRController@edit');
    Route::post('maintenance_reports/update','MRController@update');
    Route::post('maintenance_reports/done','MRController@done');

    Route::get('/maintenance_reports_projects/{id}','MRController@project');

    Route::get('/maintenance_reports_amounts/{id}','MRController@amount');

    //man_hour
    Route::get('/manhours','ManHourController@index');
    Route::get('/manhours/{id}','ManHourController@create');
    Route::post('/manhours','ManHourController@store');
    Route::get('/manhours/{id}/edit','ManHourController@edit');
    Route::post('/manhours/update','ManHourController@update');
    Route::get('/manhours/destroy/{id}','ManHourController@destroy');

    Route::post('manhours/fetchcreate', 'ManHourController@fetchcreate')->name('manhours.fetchcreate');

    Route::get('/time_confirmed','ManHourController@timeconfirmed');

    Route::post('/manhour_import_excel/{id}','ManHourController@import');

    Route::get('/plan_ot/{id}','ManHourController@planot');
    Route::post('/plan_ot','ManHourController@planotstore');
    Route::get('/plan_ot/{id}/edit','ManHourController@planotedit');
    Route::post('/plan_ot/update','ManHourController@planotupdate');
    Route::get('/plan_ot/destroy/{id}','ManHourController@planotdestroy');

    Route::post('/plan_ot_excel/{id}','ManHourController@planotimport');

    Route::get('/otframe','ManHourController@otframe');
    Route::post('/otframe','ManHourController@otframestore');
    Route::get('/otframe/{id}/edit','ManHourController@otframeedit');
    Route::post('/otframe/update','ManHourController@otframeupdate');
    Route::get('/otframe/destroy/{id}','ManHourController@otframedestroy');

    Route::get('/otframe/{id}','ManHourController@otframeproject');
    Route::post('/otframe_project','ManHourController@otframeprojectstore');
    Route::post('/otframe_project/update','ManHourController@otframeprojectupdate');

    //meeting
    Route::get('project_meetings/{projectid}/create','MeetingController@projectcreate');
    Route::post('project_meetings','MeetingController@projectstore');
    Route::delete('project_meetings/{projectmeetingid}','MeetingController@projectdestroy');
    Route::get('meetings/{projectmeetingid}/create','MeetingController@create');
    Route::post('meetings','MeetingController@store');
    Route::delete('meetings/{meetingid}','MeetingController@destroy');

    //milestone
    Route::get('/milestone_alls','MilestoneController@all');
    Route::post('/milestone_alls','MilestoneController@allstore');
    Route::get('/milestone_alls/{id}/edit','MilestoneController@alledit');
    Route::post('/milestone_alls/update','MilestoneController@allupdate');

    Route::get('/projects_milestone/{id}','MilestoneController@maintenance');
    Route::post('/projects_milestone','MilestoneController@maintenancestore');
    Route::get('/projects_milestone_update/{id}','MilestoneController@maintenanceshow');
    Route::get('/projects_milestone/{id}/edit','MilestoneController@maintenanceedit');
    Route::post('/projects_milestone/update','MilestoneController@maintenanceupdate');
    Route::post('/projects_milestone/destroy','MilestoneController@maintenancedestroy');

    Route::get('/milestone_offices/{id}/{type}','MilestoneController@office');
    Route::post('/milestone_offices','MilestoneController@officestore');
    Route::get('/milestone_offices/{id}/edit','MilestoneController@officeedit');
    Route::post('/milestone_offices/update','MilestoneController@officeupdate');

    Route::get('/milestone_record/{id}','MilestoneController@record');

    Route::get('/milestone_activities','MilestoneController@activity');
    Route::post('/milestone_activities','MilestoneController@activitystore');
    Route::get('/milestone_activities/{id}/edit','MilestoneController@activityedit');
    Route::post('/milestone_activities/update','MilestoneController@activityupdate');

    Route::get('/milestone_standards','MilestoneController@standard');
    Route::post('/milestone_standards','MilestoneController@standardstore');
    Route::get('/milestone_standards/{id}/edit','MilestoneController@standardedit');
    Route::post('/milestone_standards/update','MilestoneController@standardupdate');

    //mobilization plan
    Route::get('/mobilizationplans','MobilizationPlanController@index');
    Route::get('/mobilizationplans/{id}','MobilizationPlanController@project');
    Route::post('/mobilizationplans','MobilizationPlanController@projectstore');
    Route::get('/mobilizationplans/{id}/edit','MobilizationPlanController@projectedit');
    Route::post('/mobilizationplans/update','MobilizationPlanController@projectupdate');
    Route::get('/mobilizationplans/destroy/{id}','MobilizationPlanController@projectdestroy');

    Route::get('/mobilizationplan_calendars','MobilizationPlanController@calendar');
    Route::get('/mobilizationplan_resources','MobilizationPlanController@resource');

    Route::post('/mobilization_reports','MobilizationPlanController@report');

    //mr
    Route::get('/MR_all/{id}','MRController@report');

    //observation
    Route::get('/observations/{id}','ObservationController@index');
    Route::post('/observations','ObservationController@store');
    Route::get('/observations/{id}/edit','ObservationController@edit');
    Route::post('/observations/update','ObservationController@update');
    Route::get('/observations/destroy/{id}','ObservationController@destroy');

    //on the job training
    Route::get('/onthejobtraining_plans','OnTheJobTrainingController@plan');

    Route::get('/onthejobtraining_offices','OnTheJobTrainingController@office');
    Route::post('/onthejobtraining_offices','OnTheJobTrainingController@officestore');
    Route::get('/onthejobtraining_offices/{id}/edit','OnTheJobTrainingController@officeedit');
    Route::post('/onthejobtraining_offices/update','OnTheJobTrainingController@officeupdate');
    Route::get('/onthejobtraining_offices/destroy/{id}','OnTheJobTrainingController@officedestroy');

    Route::get('/onthejobtraining_projects/{id}','OnTheJobTrainingController@project');
    Route::post('/onthejobtraining_projects','OnTheJobTrainingController@projectstore');
    Route::get('/onthejobtraining_projects/{id}/edit','OnTheJobTrainingController@projectedit');
    Route::post('/onthejobtraining_projects/update','OnTheJobTrainingController@projectupdate');
    Route::get('/onthejobtraining_projects/destroy/{id}','OnTheJobTrainingController@projectdestroy');

    Route::post('/onthejobtraining_projects/evaluation','OnTheJobTrainingController@evaluation');

    Route::get('/onthejobtraining_approves','OnTheJobTrainingController@approved');
    Route::get('/onthejobtraining_approves/{id}/edit','OnTheJobTrainingController@approvededit');
    Route::post('/onthejobtraining_approves/update','OnTheJobTrainingController@approvedupdate');

    Route::get('/onthejobtraining_records','OnTheJobTrainingController@record');

    Route::post('dynamic_dependent/fetchjobposition', 'OnTheJobTrainingController@fetchjobposition')->name('dynamicdependent.fetchjobposition');
    Route::post('dynamic_dependent/fetchcourse', 'OnTheJobTrainingController@fetchcourse')->name('dynamicdependent.fetchcourse');

    Route::get('/trainings','OnTheJobTrainingController@training');
    Route::post('/trainings','OnTheJobTrainingController@trainingstore');
    Route::get('/trainings/{id}/edit','OnTheJobTrainingController@trainingedit');
    Route::post('/trainings/update','OnTheJobTrainingController@trainingupdate');
    Route::get('/trainings/destroy/{id}','OnTheJobTrainingController@trainingdestroy');

    //pagination
    Route::get('/pagination', 'PaginationController@index');
    Route::get('/pagination/fetch_data', 'PaginationController@fetch_data');

    //packing
    Route::get('packings/{id}','PackingController@project');

    Route::get('/packing_consumables/{id}/edit','PackingController@consumableedit');
    Route::post('/packing_consumables/update','PackingController@consumableupdate');

    Route::get('/packing_tools/{id}/edit','PackingController@tooledit');
    Route::post('/packing_tools/update','PackingController@toolupdate');

    //participation
    Route::get('/participations/{id}','ParticipationController@index');
    Route::post('/participations','ParticipationController@store');
    Route::get('/participations/{id}/edit','ParticipationController@edit');
    Route::post('/participations/update','ParticipationController@update');
    Route::get('participations/destroy/{id}','ParticipationController@destroy');

    //performance
    Route::get('/performance_employees/{id}','PerformanceController@employee');
    Route::post('/performance_employees','PerformanceController@employeestore');
    Route::get('/performance_employees/{id}/edit','PerformanceController@employeeedit');
    Route::post('/performance_employees/update','PerformanceController@employeeupdate');
    Route::get('/performance_employees/destroy/{id}','PerformanceController@employeedestroy');

    Route::get('/performance_projects/{id}','PerformanceController@project');
    Route::post('/performance_projects','PerformanceController@projectstore');
    Route::get('/performance_projects/{id}/edit','PerformanceController@projectedit');
    Route::post('/performance_projects/update','PerformanceController@projectupdate');
    Route::get('/performance_projects/destroy/{id}','PerformanceController@projectdestroy');

    //period
    Route::get('/annuals','PeriodController@annual');
    Route::post('/annuals','PeriodController@annualstore');
    Route::get('/annuals/{id}/edit','PeriodController@annualedit');
    Route::post('/annuals/update','PeriodController@annualupdate');
    Route::get('/annuals/destroy/{id}','PeriodController@annualdestroy');

    Route::get('/semiannuals/{id}','PeriodController@semiannual');
    Route::post('/semiannuals','PeriodController@semiannualstore');
    Route::get('/semiannuals/{id}/edit','PeriodController@semiannualedit');
    Route::post('/semiannuals/update','PeriodController@semiannualupdate');
    Route::get('/semiannuals/destroy/{id}','PeriodController@semiannualdestroy');

    Route::get('/quarters/{id}','PeriodController@quarter');
    Route::post('/quarters','PeriodController@quarterstore');
    Route::get('/quarters/{id}/edit','PeriodController@quarteredit');
    Route::post('/quarters/update','PeriodController@quarterupdate');
    Route::get('/quarters/destroy/{id}','PeriodController@quarterdestroy');

    Route::get('/months/{id}','PeriodController@month');
    Route::post('/months','PeriodController@monthstore');
    Route::get('/months/{id}/edit','PeriodController@monthedit');
    Route::post('/months/update','PeriodController@monthupdate');
    Route::get('/months/destroy/{id}','PeriodController@monthdestroy');

    Route::get('/weeks/{id}','PeriodController@week');
    Route::post('/weeks','PeriodController@weekstore');
    Route::get('/weeks/{id}/edit','PeriodController@weekedit');
    Route::post('/weeks/update','PeriodController@weekupdate');
    Route::get('/weeks/destroy/{id}','PeriodController@weekdestroy');

    //pm order
    Route::get('/pmorders/{id}/index','PMOrderController@index');
    Route::get('/pmorders/{id}','PMOrderController@project');
    Route::post('/pmorders','PMOrderController@store');
    Route::get('/pmorders/{id}/edit','PMOrderController@edit');
    Route::post('/pmorders/update','PMOrderController@update');
    Route::get('/pmorders/destroy/{id}','PMOrderController@destroy');

    //print
    Route::get('/checklist/{id}','PrintController@checklist');
    Route::get('/checklist2/{id}','PrintController@checklist2');
    Route::get('/checklist3/{id}','PrintController@checklist3');
    Route::get('/checklist4/{id}','PrintController@checklist4');
    Route::get('/confinedspace/{id}','PrintController@confinedspace');
    Route::get('/consumable/{projectid}','PrintController@consumable');
    Route::post('/consumable/sitepick','PrintController@consumablepick');
    Route::get('/controlmeasure_project/{id}','PrintController@countermeasureproject');
    Route::post('/crane_report/{id}','PrintController@crane_report');
    Route::get('/dangerouszone/{id}','PrintController@dangerouszone');
    Route::get('/drone/{id}','PrintController@drone');
    Route::get('/factor/{departmentid}','PrintController@factor');
    Route::get('/factor_project/{id}','PrintController@factorproject');
    Route::get('/hazard','PrintController@hazard');
    Route::get('/hoist_testing/{id}','PrintController@hoist');
    Route::get('/hotwork/{id}','PrintController@hotwork');
    Route::get('/history/{itemid}/{productid}/{locationid}/{machineid}/{systemid}/{equipmentid}','PrintController@history');
    Route::get('/knowledgeskill/{employeeid}','PrintController@knowledgeskill');
    Route::get('/law_assesment/{departmentid}/{lawid}','PrintController@lawassesment');
    Route::get('/lifting/{id}','PrintController@lifting');
    Route::post('/mobilization_report','PrintController@mobilization');
    Route::get('/MR/{id}','PrintController@MR');
    Route::get('/observation/{id}','PrintController@observation');
    Route::get('/OJTevaluation/{id}','PrintController@OJTevaluation');
    Route::get('/OJTevaluation_office/{id}','PrintController@OJTevaluationoffice');
    Route::get('/OJTmaster/{departmentid}','PrintController@OJTmaster');
    Route::get('/OJTplan/{departmentid}/{year}','PrintController@OJTplan');
    Route::get('/OJTrecord/{employeeid}','PrintController@OJTrecord');
    Route::get('/OJTotherrecord/{employeeid}','PrintController@OJTotherrecord');
    Route::post('/packing','PrintController@packing');
    Route::get('/participation1/{id}','PrintController@participation1');
    Route::get('/participation2/{id}','PrintController@participation2');
    Route::get('/pdf/{id}','PrintController@pdf');
    Route::get('/performance_manhour/{id}','PrintController@performancemanhour');
    Route::get('/performance_weekly/{id}','PrintController@performanceweekly');
    Route::post('/plan_ot_report','PrintController@planot');
    Route::post('/plan_ot_report_16','PrintController@planot16');
    Route::get('/product/{departmentid}','PrintController@product');
    Route::get('/risk/{jobid}','PrintController@risk');
    Route::get('/riskquality/{jobid}','PrintController@riskquality');
    Route::get('/riskqualityhmrs/{id}','PrintController@riskqualityhmrs');
    Route::get('/riskqualityproject/{id}','PrintController@riskqualityproject');
    Route::get('/sparepart/{projectid}','PrintController@sparepart');
    Route::get('/safetychecklist/{id}','PrintController@safetychecklist');
    Route::get('/stakeholder_project/{id}','PrintController@stakeholderproject');
    Route::post('/timesheet_report','PrintController@timesheet');
    Route::post('/time_confirmed_report','PrintController@timeconfirmed');
    Route::get('/tool/{projectid}','PrintController@tool');
    Route::get('/tool_accept/{id}','PrintController@toolaccept');
    Route::get('/tool_calibrate_list','PrintController@toolcalibratelist');
    Route::get('/tool_breakdown/{id}','PrintController@toolbreakdown');
    Route::post('/tool_calibrate_plan','PrintController@toolcalibrateplan');
    Route::get('/tool_calibrate_accept/{id}','PrintController@toolcalibrateaccept');
    Route::get('/tool_calibrate_record/{id}','PrintController@toolcalibraterecord');
    Route::get('/tool_expensives/{id}','PrintController@toolexpensive');
    Route::get('/tool_list','PrintController@toollist');
    Route::post('/tool_site_report','PrintController@toolsitereport');
    Route::post('/tool_pm_plan','PrintController@toolpmplan');
    Route::get('/tool_pm_record/{id}','PrintController@toolpmrecord');
    Route::post('/tool_preuse','PrintController@toolpreuse');
    Route::post('/tool_report','PrintController@toolreport');
    Route::post('/WFHWFA_plan','PrintController@WFHWFAplan');
    Route::post('/WFHWFA_actual','PrintController@WFHWFAactual');
    Route::get('/workathight/{id}','PrintController@workathight');
    Route::get('/workathightwind/{id}','PrintController@workathightwind');
    Route::get('/work_permit/{id}','PrintController@workpermit');
    Route::get('/worklist/{id}','PrintController@worklist');

    //product
    Route::get('/products','ProductController@index');
    Route::post('/products','ProductController@store');
    Route::get('/products/{id}/edit','ProductController@edit');
    Route::post('/products/update','ProductController@update');
    Route::get('/products/destroy/{id}','ProductController@destroy');
    Route::get('/project_products/{projectid}/create','ProductController@projectcreate');
    Route::post('/project_products','ProductController@projectstore');
    Route::delete('project_product/{projectproductid}','ProductController@projectdestroy');
    Route::get('/location_products/{projectlocationid}/create','ProductController@locationcreate');
    Route::post('/location_products','ProductController@locationstore');
    Route::delete('location_products/{locationproductid}','ProductController@locationdestroy');

    //progress
    Route::get('/progress','ProgressController@index');
    Route::get('/progress/{id}','ProgressController@create');
    Route::post('/progress','ProgressController@store');
    Route::get('/progress/{id}/edit','ProgressController@edit');
    Route::post('/progress/update','ProgressController@update');
    Route::get('/progress/destroy/{id}','ProgressController@destroy');

    Route::get('/progress_project/{id}','ProgressController@progress');

    Route::post('/progress_import_excel/{id}','ProgressController@import');

    //project
    Route::post('/projects','ProjectController@store');
    Route::get('/projects/{id}','ProjectController@show');
    Route::get('/projects/{id}/edit','ProjectController@edit');
    Route::post('/projects/update','ProjectController@update');
    Route::get('/projects/destroy/{id}','ProjectController@destroy');

    Route::get('/project_types','ProjectController@type');
    Route::post('/project_types','ProjectController@typestore');
    Route::get('/project_types/{id}/edit','ProjectController@typeedit');
    Route::post('/project_types/update','ProjectController@typeupdate');
    Route::get('/project_types/destroy/{id}','ProjectController@typedestroy');

    Route::get('/project_checklists/{id}','ProjectController@checklist');

    Route::post('/upload_keydate','ProjectController@keydate');
    Route::post('/upload_keydate/update','ProjectController@keydateupdate');
    Route::get('/upload_keydate/destroy/{id}','ProjectController@keydatedelete');

    Route::get('/project_safetyhealths/{id}','ProjectController@safetyhealth');

    Route::get('/project_procedures/{id}','ProjectController@procedure');

    Route::get('/project_calendars','ProjectController@calendar');

    //quality control
    Route::get('/qualitycontrols/{id}','QualityControlController@create');
    Route::post('/qualitycontrols','QualityControlController@store');
    Route::get('/qualitycontrols/{id}/edit','QualityControlController@edit');
    Route::post('/qualitycontrols/update','QualityControlController@update');
    Route::get('qualitycontrols/destroy/{id}','QualityControlController@destroy');

    Route::get('/qualitycontrol_projects/{id}','QualityControlController@project');

    Route::get('/qualitycontrol_amounts/{id}','QualityControlController@amount');

    //quality safety and health
    Route::get('QSH_manuals', function () {
        return view('QSHs.manual');
    });

    Route::get('QSH_departments','QSHController@department');

    Route::get('QSHs_product_stakeholder_expectation/{id}','QSHController@product_stakeholder_expectation');
    Route::post('update_product_stakeholder_expectation','QSHController@update_product_stakeholder_expectation');
    Route::post('product_stakeholder_expectation_related','QSHController@product_stakeholder_expectation_related');

    Route::get('QSHs_product_expectation_factor/{id}','QSHController@product_expectation_factor');
    Route::post('update_product_expectation_factor','QSHController@update_product_expectation_factor');
    Route::post('product_expectation_factor_related','QSHController@product_expectation_factor_related');

    Route::get('QSH_assesments/{id}','QSHController@assesment');
    Route::post('update_assesment','QSHController@update_assesment');
    Route::post('assesment_related','QSHController@assesment_related');

    Route::get('QSH_project_type_products','QSHController@projecttypeproduct');
    Route::post('QSH_project_type_products','QSHController@projecttypeproductstore');
    Route::get('QSH_project_type_products/{id}/edit','QSHController@projecttypeproductedit');
    Route::post('QSH_project_type_products/update','QSHController@projecttypeproductupdate');
    Route::get('QSH_project_type_products/destroy/{id}','QSHController@projecttypeproductdestroy');

    Route::get('QSH_product_stakeholders','QSHController@productstakeholder');
    Route::post('QSH_product_stakeholders','QSHController@productstakeholderstore');
    Route::get('QSH_product_stakeholders/{id}/edit','QSHController@productstakeholderedit');
    Route::post('QSH_product_stakeholders/update','QSHController@productstakeholderupdate');
    Route::get('QSH_product_stakeholders/destroy/{id}','QSHController@productstakeholderdestroy');

    Route::get('QSH_stakeholder_expectations','QSHController@stakeholderexpectation');
    Route::post('QSH_stakeholder_expectations','QSHController@stakeholderexpectationstore');
    Route::get('QSH_stakeholder_expectations/{id}/edit','QSHController@stakeholderexpectationedit');
    Route::post('QSH_stakeholder_expectations/update','QSHController@stakeholderexpectationupdate');
    Route::get('QSH_stakeholder_expectations/destroy/{id}','QSHController@stakeholderexpectationdestroy');

    Route::get('QSH_expectation_factors','QSHController@expectationfactor');
    Route::post('QSH_expectation_factors','QSHController@expectationfactorstore');
    Route::get('QSH_expectation_factors/{id}/edit','QSHController@expectationfactoredit');
    Route::post('QSH_expectation_factors/update','QSHController@expectationfactorupdate');
    Route::get('QSH_expectation_factors/destroy/{id}','QSHController@expectationfactordestroy');

    Route::get('QSH_typeofrisks','QSHController@typeofrisk');
    Route::post('QSH_typeofrisks','QSHController@typeofriskstore');
    Route::get('QSH_typeofrisks/{id}/edit','QSHController@typeofriskedit');
    Route::post('QSH_typeofrisks/update','QSHController@typeofriskupdate');
    Route::get('QSH_typeofrisks/destroy/{id}','QSHController@typeofriskdestroy');

    Route::get('QSH_stakeholders','QSHController@stakeholder');
    Route::get('QSH_stakeholders2','QSHController@stakeholder2');
    Route::get('QSH_stakeholders/{id}/create','QSHController@stakeholdercreate');
    Route::post('QSH_stakeholders','QSHController@stakeholderstore');
    Route::get('QSH_stakeholders/{id}/edit','QSHController@stakeholderedit');
    Route::post('QSH_stakeholders/update','QSHController@stakeholderupdate');
    Route::get('QSH_stakeholders/destroy/{id}','QSHController@stakeholderdestroy');

    Route::get('QSH_stakeholder_projects/{id}','QSHController@stakeholderproject');
    Route::post('QSH_stakeholder_projects','QSHController@stakeholderprojectstore');
    Route::get('QSH_stakeholder_projects/{id}/edit','QSHController@stakeholderprojectedit');
    Route::post('QSH_stakeholder_projects/update','QSHController@stakeholderprojectupdate');
    Route::get('QSH_stakeholder_projects/destroy/{id}','QSHController@stakeholderprojectdestroy');

    Route::get('QSH_expectations','QSHController@expectation');
    Route::get('QSH_expectations/{id}/create','QSHController@expectationcreate');
    Route::post('QSH_expectations','QSHController@expectationstore');
    Route::get('QSH_expectations/{id}/edit','QSHController@expectationedit');
    Route::post('QSH_expectations/update','QSHController@expectationupdate');
    Route::get('QSH_expectations/destroy/{id}','QSHController@expectationdestroy');

    Route::get('QSH_factors','QSHController@factorcreate');
    Route::post('QSH_factors','QSHController@factorstore');
    Route::get('QSH_factors/{id}/edit','QSHController@factoredit');
    Route::post('QSH_factors/update','QSHController@factorupdate');
    Route::get('QSH_factors/destroy/{id}','QSHController@factordestroy');

    Route::get('QSH_schedules','QSHController@schedule');
    Route::get('QSH_schedules/{id}','QSHController@schedulecreate');
    Route::post('QSH_schedules','QSHController@schedulestore');
    Route::get('QSH_schedules/{id}/edit','QSHController@scheduleedit');
    Route::post('QSH_schedules/update','QSHController@scheduleupdate');
    Route::get('QSH_schedules/destroy/{id}','QSHController@scheduledestroy');

    //responsible
    Route::get('/responsibles/{id}','ResponsibleController@project');
    Route::post('/responsibles','ResponsibleController@projectstore');
    Route::get('/responsibles/{id}/edit','ResponsibleController@projectedit');
    Route::post('/responsibles/update','ResponsibleController@projectupdate');
    Route::get('/responsibles/destroy/{id}','ResponsibleController@projectdestroy');

    //routine job
    Route::get('/routines','RoutineJobController@index');
    Route::post('/routines','RoutineJobController@store');
    Route::get('/routines/{id}/edit','RoutineJobController@edit');
    Route::post('/routines/update','RoutineJobController@update');
    Route::get('/routines/destroy/{id}','RoutineJobController@destroy');

    //safety tag
    Route::get('/safetytags/{id}','SafetyTagController@create');
    Route::post('/safetytags','SafetyTagController@store');
    Route::get('/safetytags/{id}/edit','SafetyTagController@edit');
    Route::post('/safetytags/update','SafetyTagController@update');
    Route::get('safetytags/destroy/{id}','SafetyTagController@destroy');

    Route::get('/safetytag_projects/{id}','SafetyTagController@project');

    Route::get('/safetytag_amounts/{id}','SafetyTagController@amount');

    //scope
    Route::get('/scopes','ScopeController@index');
    Route::post('/scopes','ScopeController@store');
    Route::get('/scopes/{id}/edit','ScopeController@edit');
    Route::post('/scopes/update','ScopeController@update');
    Route::get('/scopes/destroy/{id}','ScopeController@destroy');

    //spare part
    Route::get('/spareparts','SparePartController@index');
    Route::post('/spareparts','SparePartController@store');
    Route::get('/spareparts/{id}/edit','SparePartController@edit');
    Route::post('/spareparts/update','SparePartController@update');
    Route::get('/spareparts/destroy{id}','SparePartController@destroy');

    Route::get('/item_spareparts/{id}','SparePartController@itemcreate');
    Route::post('/item_spareparts','SparePartController@itemstore');
    Route::get('/item_spareparts/{id}/edit','SparePartController@itemedit');
    Route::post('/item_spareparts/update','SparePartController@itemupdate');
    Route::get('/item_spareparts/destroy/{id}','SparePartController@itemdestroy');

    Route::get('/sparepart_projects/{id}','SparePartController@project');

    Route::get('/sparepart_amounts/{id}','SparePartController@amount');

    //special tool
    Route::get('/specialtools/{id}','SpecialToolController@item');
    Route::post('/specialtools','SpecialToolController@store');
    Route::get('/specialtools/{id}/edit','SpecialToolController@edit');
    Route::post('/specialtools/update','SpecialToolController@update');
    Route::post('/specialtools/change','SpecialToolController@change');
    Route::get('specialtools/destroy/{id}','SpecialToolController@destroy');

    Route::get('/specialtool_projects/{id}','SpecialToolController@project');

    Route::get('/specialtool_amounts/{id}','SpecialToolController@amount');

    //support man
    Route::get('/support_man/{id}','SupportRequestController@man');
    Route::post('/support_man','SupportRequestController@manstore');
    Route::get('/support_man/{id}/edit','SupportRequestController@manedit');
    Route::post('/support_man/update','SupportRequestController@manupdate');
    Route::get('support_man/destroy/{id}','SupportRequestController@mandestroy');

    Route::get('/support_man_employee','SupportRequestController@manemployee');
    Route::post('/support_man_employee/update','SupportRequestController@manemployeeupdate');

    //support request
    Route::get('/support_request/{id}','SupportRequestController@request');
    Route::post('/support_request','SupportRequestController@requeststore');
    Route::get('/support_request/{id}/edit','SupportRequestController@requestedit');
    Route::post('/support_request/update','SupportRequestController@requestupdate');
    Route::get('support_request/destroy/{id}','SupportRequestController@requestdestroy');

    //system
    Route::get('/systems','SystemController@index');
    Route::post('/systems','SystemController@store');
    Route::get('/systems/{id}/edit','SystemController@edit');
    Route::post('/systems/update','SystemController@update');
    Route::get('/systems/destroy/{id}','SystemController@destroy');
    Route::get('/machine_systems/{productmachineid}/create','SystemController@machinecreate');//->middleware('permission:create projects');
    Route::post('/machine_systems','SystemController@machinestore');
    Route::delete('machine_systems/{machinesystemid}','SystemController@machinedestroy');

    //test
    Route::get('test/','TestController@index');
    Route::get('test/{id}','TestController@index2');
    Route::get('testbtn','TestController@testbtn');
    Route::get('testprint','TestController@testprint');

    Route::get('vue','TestController@vue');

    //tool
    Route::get('tools/{id}','ToolController@tool');
    Route::post('tools','ToolController@toolstore');
    Route::get('tools/{id}/edit','ToolController@tooledit');
    Route::post('tools/update','ToolController@toolupdate');
    Route::get('tools/destroy/{id}','ToolController@tooldestroy');

    Route::get('tool_historys/{id}','ToolController@history');
    Route::post('tool_historys','ToolController@historystore');

    Route::get('tool_catagories','ToolController@catagory');
    Route::get('tool_catagories/create','ToolController@catagorycreate');
    Route::post('tool_catagories','ToolController@catagorystore');
    Route::get('tool_catagories/{id}','ToolController@catagoryshow');
    Route::get('tool_catagories/{id}/edit','ToolController@catagoryedit');
    Route::post('tool_catagories/update','ToolController@catagoryupdate');
    Route::get('tool_catagories/destroy/{id}','ToolController@catagorydestroy');

    Route::get('/item_tool_catagories/{id}','ToolController@itemcatagorycreate');
    Route::post('/item_tool_catagories','ToolController@itemcatagorystore');
    Route::get('/item_tool_catagories/{itemtoolcatagoryid}/edit','ToolController@itemcatagoryedit');
    Route::post('/item_tool_catagories/update','ToolController@itemcatagoryupdate');
    Route::get('/item_tool_catagories/destroy/{itemtoolcatagoryid}','ToolController@itemcatagorydestroy');

    Route::get('/tool_catagory_sites/{id}','ToolController@catagorysitepick');
    Route::post('/tool_catagory_sites','ToolController@catagorysitepickstore');
    Route::get('/tool_catagory_sites/{id}/edit','ToolController@catagorysiteedit');
    Route::post('/tool_catagory_sites/update','ToolController@catagorysiteupdate');
    Route::get('/tool_catagory_sites/destroy/{id}','ToolController@catagorysitedestroy');

    Route::get('/tool_sites/{id}','ToolController@toolsitepick');
    Route::post('/tool_sites','ToolController@toolsitepickstore');
    Route::get('/tool_sites/{id}/edit','ToolController@toolsiteedit');
    Route::post('/tool_sites/update','ToolController@toolsiteupdate');
    Route::get('/tool_sites/destroy/{id}','ToolController@toolsitedestroy');
    Route::post('/tool_sites/transfer','ToolController@toolsitetransfer');

    Route::get('tool_PMs','ToolController@PM');
    Route::post('tool_PMs','ToolController@PMstore');
    Route::get('tool_PMs/{id}','ToolController@PMhistory');

    Route::get('tool_PM_intervals/{id}','ToolController@pminterval');
    Route::post('tool_PM_intervals','ToolController@pmintervalstore');
    Route::get('tool_PM_intervals/{id}/edit','ToolController@pmintervaledit');
    Route::post('tool_PM_intervals/update','ToolController@pmintervalupdate');
    Route::get('tool_PM_intervals/destroy/{id}','ToolController@pmintervaldestroy');

    Route::get('tool_pre_use_activities/{id}','ToolController@preuseactivity');
    Route::post('tool_pre_use_activities','ToolController@preuseactivitystore');
    Route::get('tool_pre_use_activities/{id}/edit','ToolController@preuseactivityedit');
    Route::post('tool_pre_use_activities/update','ToolController@preuseactivityupdate');
    Route::get('tool_pre_use_activities/destroy/{id}','ToolController@preuseactivitydestroy');

    Route::get('tool_calibrates','ToolController@calibrate');
    Route::get('tool_calibrates_all','ToolController@calibrateall');
    Route::post('tool_calibrates','ToolController@calibratestore');
    Route::get('tool_calibrates/{id}/edit','ToolController@calibrateedit');
    Route::post('tool_calibrates/update','ToolController@calibrateupdate');
    Route::get('tool_calibrates/destroy/{id}','ToolController@calibratedestroy');
    Route::get('tool_calibrates/{id}','ToolController@calibratehistory');

    Route::get('tool_expensive/{id}','ToolController@expensive');
    Route::post('tool_expensive','ToolController@expensivestore');
    Route::get('tool_expensive/{id}/edit','ToolController@expensiveedit');
    Route::post('tool_expensive/update','ToolController@expensiveupdate');
    Route::get('tool_expensive/destroy/{id}','ToolController@expensivedestroy');

    Route::get('/tool_breakdowns','ToolController@breakdown');
    Route::post('/tool_breakdowns','ToolController@breakdownstore');
    Route::get('/tool_breakdowns/{id}/edit','ToolController@breakdownedit');
    Route::post('/tool_breakdowns/update','ToolController@breakdownupdate');
    Route::get('/tool_breakdowns/destroy/{id}','ToolController@breakdowndestroy');

    Route::get('/tool_types','ToolController@type');
    Route::post('/tool_types','ToolController@typestore');
    Route::get('/tool_types/{id}/edit','ToolController@typeedit');
    Route::post('/tool_types/update','ToolController@typeupdate');
    Route::get('/tool_types/destroy/{id}','ToolController@typedestroy');

    Route::get('tool_preuses/{id}','ToolController@preuse');

    Route::get('/tool_projects/{id}','ToolController@project');

    Route::get('/tool_project_certificate/{id}','ToolController@projectcertificate');

    Route::get('/tool_amounts/{id}','ToolController@amount');

    //upload
    Route::post('/upload_attachment','UploadFileController@project');
    Route::post('/upload_attachment/update','UploadFileController@projectupdate');
    Route::get('/upload_attachment/destroy/{id}/{type}','UploadFileController@projectdelete');

    Route::post('/upload_tool','UploadFileController@tool');
    Route::post('/upload_tool/update','UploadFileController@toolupdate');
    Route::get('/upload_tool/destroy/{id}/{type}','UploadFileController@tooldelete');

    //user
    Route::get('/users','UserController@index')->middleware('auth');
    Route::get('/users/{id}/edit','UserController@edit');
    Route::post('/users/update','UserController@update');
    Route::get('/users/destroy/{id}','UserController@destroy');

    Route::get('/user_employees','UserController@employee');
    Route::get('/user_employees/{id}/edit','UserController@employeeedit');
    Route::post('/user_employees/update','UserController@employeeupdate');

    Route::get('/user_roles','UserController@role');
    Route::post('/user_roles','UserController@rolestore');
    Route::get('/user_roles/destroy/{userid}/{roleid}','UserController@roledestroy');

    //work at hight
    Route::get('/workathights/{id}','WorkAtHightController@create');
    Route::post('/workathights','WorkAtHightController@store');
    Route::get('/workathights/{id}/edit','WorkAtHightController@edit');
    Route::post('/workathights/update','WorkAtHightController@update');
    Route::get('/workathights/destroy/{id}','WorkAtHightController@destroy');

    //WFH WFA
    Route::get('/WFH_WFA_weeks','WFHWFAController@week');

    Route::get('/WFH_WFA_assignments/{StartDate}','WFHWFAController@assignment');
    Route::post('/WFH_WFA_assignments','WFHWFAController@assignmentstore');
    Route::get('/WFH_WFA_assignments/{id}/edit','WFHWFAController@assignmentedit');
    Route::post('/WFH_WFA_assignments/update','WFHWFAController@assignmentupdate');
    Route::get('/WFH_WFA_assignments/destroy/{id}','WFHWFAController@assignmentdestroy');

    Route::get('/WFH_WFA_jobs/{id}','WFHWFAController@job');
    Route::post('/WFH_WFA_jobs','WFHWFAController@jobstore');
    Route::get('/WFH_WFA_jobs/{id}/edit','WFHWFAController@jobedit');
    Route::post('/WFH_WFA_jobs/update','WFHWFAController@jobupdate');
    Route::get('/WFH_WFA_jobs/destroy/{id}','WFHWFAController@jobdestroy');

    Route::post('/WFH_WFA_jobs/evaluate','WFHWFAController@evaluate');

    //work at hight (wind)
    Route::get('/workathight_winds/{id}','WorkAtHightWindController@create');
    Route::post('/workathight_winds','WorkAtHightWindController@store');
    Route::get('/workathight_winds/{id}/edit','WorkAtHightWindController@edit');
    Route::post('/workathight_winds/update','WorkAtHightWindController@update');
    Route::get('/workathight_winds/destroy/{id}','WorkAtHightWindController@destroy');

    //work permit
    Route::get('/work_permits/{id}','WorkPermitController@index');
    Route::post('/work_permits','WorkPermitController@store');
    Route::get('/work_permits/{id}/edit','WorkPermitController@edit');
    Route::post('/work_permits/update','WorkPermitController@update');
    Route::get('/work_permits/destroy/{id}','WorkPermitController@destroy');

    //workprocedure
    Route::get('/workprocedures/{id}','WorkProcedureController@create');
    Route::post('/workprocedures','WorkProcedureController@store');
    Route::get('/workprocedures/{id}/edit','WorkProcedureController@edit');
    Route::post('/workprocedures/update','WorkProcedureController@update');
    Route::get('workprocedures/destroy/{id}','WorkProcedureController@destroy');
    Route::post('dynamic_dependent/fetchactivity', 'WorkProcedureController@fetchactivity')->name('dynamicdependent.fetchactivity');

    Route::get('/workprocedures2/{id}','WorkProcedureController@create2');
    Route::post('/workprocedures2','WorkProcedureController@store2');
    Route::get('/workprocedures2/{id}/edit','WorkProcedureController@edit2');
    Route::post('/workprocedures2/update','WorkProcedureController@update2');
    Route::get('workprocedures2/destroy/{id}','WorkProcedureController@destroy2');
    Route::post('dynamic_dependent/fetchcreate', 'WorkProcedureController@fetchcreate')->name('dynamicdependent.fetchcreate');
    Route::post('dynamic_dependent/fetchedit', 'WorkProcedureController@fetchedit')->name('dynamicdependent.fetchedit');

    Route::get('/workprocedure_projects/{id}','WorkProcedureController@project');

    Route::get('/workprocedure_amounts/{id}','WorkProcedureController@amount');
});
