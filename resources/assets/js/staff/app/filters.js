import Vue from "vue";
import moment from "moment";

Vue.filter("date", function(value) {
  return moment(value).format("DD/MM/YYYY");
});
Vue.filter("capitalize", function(value) {
  if (!value) return "";
  value = value.toString();
  return value.charAt(0).toUpperCase() + value.slice(1);
});
Vue.filter("ucwords", function(value) {
  if (!value) return "";
  return (value + "").replace(/^(.)|\s+(.)/g, function($1) {
    return $1.toUpperCase();
  });
});
Vue.filter("gbp", function(value) {
  if (!value) return "";
  return "£" + value;
});
Vue.filter("isRequired", function(value) {
  if (value) return "Yes";
  else return "No";
});
Vue.filter("docType", function(value) {
  if (value == 1) return "Document";
  else return "Training";
});
Vue.filter("appStatus", function(value) {
  if (value) return "";
});
Vue.filter("AttendeeType", function(value) {
  if (value == 1) return "Applicants & Staff";
  else if(value == 2) return "Applicant Only";
  else return "Staff Only";
});
Vue.filter("AttendanceConfirmation", function(value) {
  if (value == 1) return "Yes";
  else return "No";
});
Vue.filter("covidResult", function(value) {
  if (value == 0) return "Negative";
  else return "Positive";
});
Vue.filter("branchName", function(value) {
  if (value == 1) return "Lancashire";
  else if(value == 2) return "Warrington";
  else if(value == 3) return "Crewes";
  else if(value == 4) return "Liverpool";
  else if(value == 5) return "Manchester";
  else if(value == 6) return "Leeds";
  else if(value == 7) return "Shrewsbury";
  else if(value == 8) return "Chester";
  else if(value == 9) return "Permanent";
  else if(value == 10) return "Complex Care";
  else if(value == 11) return "Head Office";
});
Vue.filter("shiftType", function(value) {
  if (value == 0) return "Days";
  else if(value == 1) return "Nights";
  else if(value == 2) return "Both";
});
Vue.filter('vaccinated', function(value) {
  if (value == 0) return "No";
  else return "Yes";
})
Vue.filter("applicationStatus", function(value) {
  if (value == 0) return "Application";
  else if(value == 1) return "Application";
  else if(value == 2) return "Interview";
  else if(value == 3) return "Offered";
  else if(value == 4) return "Onboarding";
  else if(value == 5) return "Active";
  else if(value == 6) return "Leaver";
  else if(value == 7) return "Pipeline";
});

