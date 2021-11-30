import Vue from "vue";
import VueRouter from "vue-router";
import RouterBase from "./components/RouterBase.vue";
Vue.use(VueRouter);

// => System
import Settings from "./components/user/settings/Settings.vue";

// => Productivity
import ProductivityTasks from "./components/productivity/Tasks.vue";
import CallsDashboard from './components/calls/Callbacks.vue'

// => Events
import TrainingDashboard from "./components/events/training/Main.vue";
import TrainingView from "./components/events/training/Event.vue";
import InductionDashboard from "./components/events/induction/Main.vue";
import InductionView from "./components/events/induction/Event.vue";

// => Dashboards
import RecruitmentDashboard from "./components/dashboards/recruitment/Main.vue";
import LiveStaffDashboard from "./components/dashboards/liveStaff/Main.vue";
import CarehomeDashboard from "./components/dashboards/carehome/Overall.vue";

// => Recruitment
	// => Applications
	import ApplicationsTable from "./components/recruitment/Applications.vue";
	import ApplicationView from "./components/recruitment/Main.vue";

	// => Interviews
	import InterviewsTable from "./components/recruitment/interviews/Datatable.vue";

	// => References
	import ReferencesTable from "./components/recruitment/references/Datatable.vue";

	// => Other
	import RetrievalsLog from "./components/recruitment/RetrievalsLog.vue";
	import RecruitmentPipeline from "./components/recruitment/pipeline/Main.vue";
	import InitialEnquiryForm from "./components/recruitment/initialEnquiry/Main.vue";
	import ConversionTracker from "./components/recruitment/conversionTracker/Main.vue";
	import MassEmails from "./components/recruitment/massEmailing/Main.vue";
    import SmsTemplate from "./components/recruitment/smsTemplate.vue";
    import smslog from "./components/recruitment/smslog.vue";
    import MassSms from "./components/recruitment/MassSms/MassSms.vue";



// => Applicant map
import GoogleMap from "./components/googleMap/Map.vue";

// => Live Staff
import LiveStaffTable from "./components/liveStaff/Table.vue";
import PulseRecords from "./components/pulse/Table.vue";
import PDFGenerator from "./components/liveStaff/profile/Generator.vue";

// => Compliance
import ComplianceDocuments from "./components/compliance/Create.vue";
import ComplianceMatrix from "./components/compliance/Matrix.vue";
import ComplianceTracker from "./components/compliance/Tracker.vue";

// => Audit Dashboard
import Dashboard from "./components/auditDashboard/Dashboard/Main.vue";
import Instruction from "./components/auditDashboard/HowTo/Main.vue";
import Procedure from "./components/auditDashboard/Procedures/Main.vue";
import Template from "./components/auditDashboard/Templates/Main.vue";
import Upload from "./components/auditDashboard/Checkout/Upload/Form.vue";
import UploadTable from "./components/auditDashboard/Checkout/Main.vue"
import UploadView from "./components/auditDashboard/Checkout/Table/Main.vue"
import ViewerView from "./components/auditDashboard/Checkout/Table/Viewers.vue"

// => Management
import ManagementStaff from "./components/management/staff/Staff.vue";
import StaffAccess from "./components/management/staff/Access.vue";

// => Covid Results
import PortalResultsTable from "./components/covidResults/portal/Main.vue";
import CovidResultsView from "./components/covidResults/portal/components/AllResults.vue";

// => Vaccinations
import VaccinationList from "./components/vaccinations/new/Main.vue";
import VaccinationsView from "./components/vaccinations/new/components/Vaccinations.vue";

// => Carehome
import CarehomeList from "./components/carehomes/Carehomes.vue";
import CarehomeView from "./components/carehomes/Main.vue";

// => Complex Care
import SignOffForm from "./components/complexCare/Competencies/SignOffForm.vue";
import UploadedForms from "./components/complexCare/Competencies/Datatable.vue";

// => IT Support
import ContactSupport from "./components/support/Form.vue";
import Cv from "./components/support/CvParse.vue";

// => Branch Reporting
import BranchReporting from "./components/branch/reporting/Main.vue";

// => Staff Onboarding
import StaffOnboarding from "./components/cavalrycareStaff/staffOnboarding/Form.vue";
import StaffOffboarding from "./components/cavalrycareStaff/staffOffboarding/Form.vue";

// => Misc
import Error404 from "../../common/components/error/404.vue";
import Error503 from "../../common/components/error/503.vue";

const routes = [{
		path: "/",
		redirect: "/dashboard/overall",
	},
	{
		path: "/productivity",
		component: RouterBase,
		children: [{
			path: "tasks",
			component: ProductivityTasks,
			name: "Tasks",
		}, ],
	},
	{
		path: "/dashboard",
		component: RouterBase,
		children: [{
				path: "overall",
				component: RecruitmentDashboard,
				name: "RecruitmentDashboard",
			},
			{
				path: "overall/:scope",
				component: RecruitmentDashboard,
			},
		],
	},
	{
		path: '/callbacks',
		component: CallsDashboard,
		name: 'Calls',
	},
	{
		path: "/training",
		component: RouterBase,
		children: [{
				path: "booking",
				component: TrainingDashboard,
				name: "TrainingDashboard",
			},
			{
				path: "booking/:id",
				component: TrainingView,
				name: "TrainingView",
			},
			{
				path: "booking/:id/:tab",
				component: TrainingView,
			},
		],
	},
	{
		path: "/induction",
		component: RouterBase,
		children: [{
				path: "booking",
				component: InductionDashboard,
				name: "InductionDashboard",
			},
			{
				path: "booking/:id",
				component: InductionView,
				name: "InductionView",
			},
			{
				path: "booking/:id/:tab",
				component: InductionView,
			},
		],
	},
	{
		path: "/recruitment",
		component: RouterBase,
		children: [{
				path: "applications",
				component: ApplicationsTable,
				name: "ApplicationsTable",
			},
			{
				path: "applications/:id",
				component: ApplicationView,
				name: "ApplicationView",
			},
			{
				path: "applications/:id/:tab",
				component: ApplicationView,
			},
			{
				path: "interviews",
				component: InterviewsTable,
				name: "InterviewsTable",
			},
			{
				path: "references",
				component: ReferencesTable,
				name: "ReferencesTable",
			},
			{
				path: "retrievals-log",
				component: RetrievalsLog,
				name: "RetrievalsLog",
			},
			{
				path: "pipeline",
				component: RecruitmentPipeline,
				name: "RecruitmentPipeline",
			},
			{
				path: "enquiry-form",
				component: InitialEnquiryForm,
				name: "InitialEnquiryForm",
			},
			{
				path: "conversion-tracker",
				component: ConversionTracker,
				name: "ConversionTracker",
			},
			{
				path: "mass-emailing",
				component: MassEmails,
				name: "MassEmails",
			},
            {
                path: "MassSms",
                component: MassSms,
                name: "MassSms",
            },
            {
                path: "smstemplate",
                component: SmsTemplate,
                name: "SmsTemplate",
            },
            {
                path: "smslog",
                component: smslog,
                name: "smslog",
            },
		],
	},
	{
		path: "/applicant",
		component: RouterBase,
		children: [{
			path: "map",
			component: GoogleMap,
			name: "GoogleMap",
		}, ],
	},
	{
		path: "/live-staff",
		component: RouterBase,
		children: [{
				path: "dashboard",
				component: LiveStaffDashboard,
				name: "LiveStaffDashboard",
			},
			{
				path: "staff",
				component: LiveStaffTable,
				name: "LiveStaffTable",
			},
			{
				path: "profile-generator",
				component: PDFGenerator,
				name: "PDFGenerator"
			},
		],
	},
	{
		path: "/covid",
		component: RouterBase,
		children: [{
				path: "results",
				component: PortalResultsTable,
				name: "PortalResultsTable",
			},
			{
				path: "results/:id",
				component: CovidResultsView,
				name: "CovidResultsView",
			},
		],
	},
	{
		path: "/vaccinations",
		component: RouterBase,
		children: [
			{
				path: "list",
				component: VaccinationList,
				name: "VaccinationList",
			},
			{
				path: "list/:id",
				component: VaccinationsView,
				name: "VaccinationsView",
			},
		],
	},
	{
		path: "/compliance",
		component: RouterBase,
		children: [{
				path: "documents",
				component: ComplianceDocuments,
				name: "ComplianceDocuments",
			},
			{
				path: "matrix",
				component: ComplianceMatrix,
				name: "ComplianceMatrix",
			},
			{
				path: "tracker",
				component: ComplianceTracker,
				name: "ComplianceTracker",
			},
		],
	},
	// {
	// 	path: "/business",
	// 	component: RouterBase,
	// 	children: [{
	// 			path: "client-list",
	// 			component: ClientsTable,
	// 			name: "ClientsTable",
	// 		},
	// 		{
	// 			path: "client-list/:id",
	// 			component: ClientView,
	// 			name: "ClientView",
	// 		},
	// 		{
	// 			path: "client-list/:id/:tab",
	// 			component: ClientView,
	// 		},
	// 		{
	// 			path: "create-client",
	// 			component: ClientForm,
	// 			name: "ClientForm",
	// 		},
	// 		{
	// 			path: "organisation-list",
	// 			component: OrganisationsTable,
	// 			name: "OrganisationsTable",
	// 		},
	// 		{
	// 			path: "create-organisation",
	// 			component: OrganisationForm,
	// 			name: "OrganisationForm",
	// 		},
	// 	],
	// },
	{
		path: "/compliance",
		component: RouterBase,
		children: [{
				path: "dashboard",
				component: Dashboard,
				name: "Dashboard",
			},
			{
				path: "instructions",
				component: Instruction,
				name: "Instruction",
			},
			{
				path: "procedures",
				component: Procedure,
				name: "Procedure",
			},
			{
				path: "templates",
				component: Template,
				name: "Template",
			},
			{
				path: "upload",
				component: Upload,
				name: "Upload",
			},
			{
				path: "upload-table",
				component: UploadTable,
				name: "UploadTable",
			},
			{
				path: "upload-table/:id",
				component: UploadView,
				name: "UploadView",
			},
			{
				path: "upload-table/:id/:file",
				component: ViewerView,
				name: "ViewerView",
			},
		],
	},
	{
		path: "/pulse",
		component: RouterBase,
		children: [{
			path: "records",
			component: PulseRecords,
			name: "PulseRecords",
		}, ],
	},
	{
		path: "/user",
		component: RouterBase,
		children: [{
			path: "settings",
			component: Settings,
			name: "UserSettings",
		}, ],
	},
	{
		path: "/management",
		component: RouterBase,
		beforeEnter: (to, from, next) => {
			axios
				.get("/api/auth/manager")
				.then((response) => {
					next();
				})
				.catch((error) => {
					next("/404");
				});
		},
		children: [{
			path: "staff/users",
			component: ManagementStaff,
			name: "ManagerStaffAccounts",
		}, {
            path: "staff/Access",
            component: StaffAccess,
            name: "Access",


        }, ],

	},
	{
		path: "/carehome",
		component: RouterBase,
		children: [{
			path: "list",
			component: CarehomeList,
			name: "CarehomeList",
		}, {
			path: "list/:id",
			component: CarehomeView,
			name: "CarehomeView",
		},],
	},
	{
		path: "/carehome",
		component: RouterBase,
		children: [{
			path: "dashboard",
			component: CarehomeDashboard,
			name: "CarehomeDashboard",
		},],
	},
	{
		path: "/complex-care/competencies",
		component: RouterBase,
		children: [{
			path: "sign-off-form",
			component: SignOffForm,
			name: "SignOffForm",
		},
		{
			path: "uploads",
			component: UploadedForms,
			name: "UploadedForms",
		}, ],
	},
	{
		path: '/contact',
		component: ContactSupport,
		name: 'ContactSupport',
		children: [{
		  path: 'support',
		  component: ContactSupport,
		}]
	},
    {
        path: '/cv',
        component: Cv,
        name: 'Cv',
        children: [{
            path: 'Cv',
            component: Cv,
        }]
    },
	{
		path: "/branch/reporting/:branch",
		component: BranchReporting,
		name: "BranchReporting",
	},
	{
		path: "/staff-onboarding",
		component: StaffOnboarding,
		name: "StaffOnboarding",
	},
	{
		path: "/staff-offboarding",
		component: StaffOffboarding,
		name: "StaffOffboarding",
	},
	{
		path: "/503",
		component: Error503,
	},
	{
		path: "/404",
		component: Error404,
	},
	{
		path: "/*",
		component: Error404,
	},
];
export default new VueRouter({
	routes,
	mode: "history",
});
