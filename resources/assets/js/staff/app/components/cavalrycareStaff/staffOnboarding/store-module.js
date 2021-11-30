import axios from 'axios'

const api = axios.create({
  baseURL: '/api/...',
  timeout: 20000
})

export const onboarding = {
  namespaced: true,
  state: {
    formData: {
      full_name: "",
      email_address: "",
      address_line_1: "",
      address_line_2: "",
      postcode: "",
      town: "",
      mobile_number: "",
      home_number: "",
      marital_status: "",
      gender: "",
      date_of_birth: "",
      national_insurance_number: "",
      bank: "",
      account_title: "",
      account_number: "",
      passport_number: "",
      sort_code: "",
      payslip_access_password: "",
      payslip_access_email: "",
      emergency_contact_name: "",
      emergency_contact_number: "",
      emergency_contact_relation: "",
      terms_and_conditions: "",
      onboarding_date: "",
      print_name: "",
      images: [],
    },
  },
  mutations: {

  },
  actions: {
    
  }

}
