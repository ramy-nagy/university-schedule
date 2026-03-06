class l{constructor(){this.baseUrl="/api",this.csrfToken=document.querySelector('meta[name="csrf-token"]')?.getAttribute("content")||"",this.setupInterceptors()}setupInterceptors(){fetch.defaultHeaders={"Content-Type":"application/json","X-CSRF-TOKEN":this.csrfToken,Accept:"application/json"}}async request(e,t,s=null,a=null){const i=a?`${this.baseUrl}/${a}${t}`:`${this.baseUrl}${t}`,r={method:e,headers:{"Content-Type":"application/json","X-CSRF-TOKEN":this.csrfToken,Accept:"application/json"}};s&&(e==="POST"||e==="PUT"||e==="PATCH")&&(r.body=JSON.stringify(s));try{const o=await fetch(i,r),c=await o.json();return o.ok?c:(this.handleError(c),null)}catch(o){return this.showNotification("Error",o.message,"error"),null}}handleError(e){e.errors?Object.keys(e.errors).forEach(t=>{const s=Array.isArray(e.errors[t])?e.errors[t][0]:e.errors[t];this.showFieldError(t,s)}):this.showNotification("Error",e.message||"An error occurred","error")}showFieldError(e,t){const s=document.querySelector(`[name="${e}"]`);if(s){s.classList.add("is-invalid");const a=s.nextElementSibling;if(a?.classList.contains("invalid-feedback"))a.textContent=t;else{const i=document.createElement("div");i.className="invalid-feedback d-block",i.textContent=t,s.parentNode.appendChild(i)}}}clearFieldErrors(){document.querySelectorAll(".form-control.is-invalid").forEach(e=>{e.classList.remove("is-invalid")})}showNotification(e,t,s="success",a=5e3){const i=document.getElementById("notifications-container")||this.createNotificationContainer(),r=document.createElement("div");return r.className=`alert alert-${this.getAlertType(s)} alert-dismissible fade show notification-toast`,r.role="alert",r.innerHTML=`
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-${this.getIcon(s)} flex-shrink-0 mt-1"></i>
                <div>
                    <strong>${e}</strong>
                    <p class="mb-0 small mt-1">${t}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `,i.appendChild(r),a>0&&setTimeout(()=>{r.remove()},a),r}createNotificationContainer(){const e=document.createElement("div");e.id="notifications-container",e.className="notifications-container",document.body.appendChild(e);const t=document.createElement("style");return t.textContent=`
            .notifications-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                max-width: 400px;
                gap: 10px;
                display: flex;
                flex-direction: column;
            }
            .notification-toast {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                animation: slideIn 0.3s ease-out;
                min-width: 300px;
            }
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @media (max-width: 576px) {
                .notifications-container {
                    right: 10px;
                    left: 10px;
                    max-width: none;
                }
                .notification-toast {
                    min-width: auto;
                }
            }
        `,document.head.appendChild(t),e}getAlertType(e){return{success:"success",error:"danger",warning:"warning",info:"info"}[e]||"info"}getIcon(e){return{success:"check-circle-fill",error:"exclamation-circle-fill",warning:"exclamation-triangle-fill",info:"info-circle-fill"}[e]||"info-circle-fill"}async getDoctors(e=1,t="",s=15){return this.request("GET",`/admin/doctors?page=${e}&search=${t}&per_page=${s}`)}async getDoctor(e){return this.request("GET",`/admin/doctors/${e}`)}async createDoctor(e){return this.request("POST","/admin/doctors",e)}async updateDoctor(e,t){return this.request("PUT",`/admin/doctors/${e}`,t)}async deleteDoctor(e){return this.request("DELETE",`/admin/doctors/${e}`)}async bulkDeleteDoctors(e){return this.request("POST","/admin/doctors/bulk-delete",{ids:e})}async getHalls(e=1,t="",s=15){return this.request("GET",`/admin/halls?page=${e}&search=${t}&per_page=${s}`)}async getHall(e){return this.request("GET",`/admin/halls/${e}`)}async createHall(e){return this.request("POST","/admin/halls",e)}async updateHall(e,t){return this.request("PUT",`/admin/halls/${e}`,t)}async deleteHall(e){return this.request("DELETE",`/admin/halls/${e}`)}async bulkDeleteHalls(e){return this.request("POST","/admin/halls/bulk-delete",{ids:e})}async getSubjects(e=1,t="",s=15){return this.request("GET",`/admin/subjects?page=${e}&search=${t}&per_page=${s}`)}async getSubject(e){return this.request("GET",`/admin/subjects/${e}`)}async createSubject(e){return this.request("POST","/admin/subjects",e)}async updateSubject(e,t){return this.request("PUT",`/admin/subjects/${e}`,t)}async deleteSubject(e){return this.request("DELETE",`/admin/subjects/${e}`)}async bulkDeleteSubjects(e){return this.request("POST","/admin/subjects/bulk-delete",{ids:e})}async getStudentGroups(e=1,t="",s=15){return this.request("GET",`/admin/student-groups?page=${e}&search=${t}&per_page=${s}`)}async getStudentGroup(e){return this.request("GET",`/admin/student-groups/${e}`)}async createStudentGroup(e){return this.request("POST","/admin/student-groups",e)}async updateStudentGroup(e,t){return this.request("PUT",`/admin/student-groups/${e}`,t)}async deleteStudentGroup(e){return this.request("DELETE",`/admin/student-groups/${e}`)}async bulkDeleteStudentGroups(e){return this.request("POST","/admin/student-groups/bulk-delete",{ids:e})}async getSchedules(e=1,t="",s=15){return this.request("GET",`/admin/schedules?page=${e}&search=${t}&per_page=${s}`)}async getSchedule(e){return this.request("GET",`/admin/schedules/${e}`)}async createSchedule(e){return this.request("POST","/admin/schedules",e)}async updateSchedule(e,t){return this.request("PUT",`/admin/schedules/${e}`,t)}async deleteSchedule(e){return this.request("DELETE",`/admin/schedules/${e}`)}async checkScheduleConflicts(e){return this.request("POST","/admin/schedules/conflicts/check",e)}async bulkDeleteSchedules(e){return this.request("POST","/admin/schedules/bulk-delete",{ids:e})}async getStudents(e=1,t="",s=15){return this.request("GET",`/admin/students?page=${e}&search=${t}&per_page=${s}`)}async getStudent(e){return this.request("GET",`/admin/students/${e}`)}async createStudent(e){return this.request("POST","/admin/students",e)}async updateStudent(e,t){return this.request("PUT",`/admin/students/${e}`,t)}async deleteStudent(e){return this.request("DELETE",`/admin/students/${e}`)}async bulkDeleteStudents(e){return this.request("POST","/admin/students/bulk-delete",{ids:e})}async getAdminDashboard(){return this.request("GET","/admin/dashboard")}async getDoctorDashboard(){return this.request("GET","/doctor/dashboard")}async getDoctorSchedules(e=1,t=null){let s=`/doctor/schedules?page=${e}`;return t&&(s+=`&date=${t}`),this.request("GET",s)}async getDoctorSchedule(e){return this.request("GET",`/doctor/schedules/${e}`)}async getStudentDashboard(){return this.request("GET","/student/dashboard")}async getStudentSchedules(e=1,t=null){let s=`/student/schedules?page=${e}`;return t&&(s+=`&date=${t}`),this.request("GET",s)}async getStudentSchedule(e){return this.request("GET",`/student/schedules/${e}`)}}new l;document.addEventListener("DOMContentLoaded",()=>{u()});function u(){document.querySelector('meta[name="csrf-token"]')||document.querySelector('meta[name="csrf-token"]')?.getAttribute("content")||console.warn("CSRF token not found in meta tags"),h(),d(),p()}function h(){document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(n=>{new bootstrap.Tooltip(n)}),document.querySelectorAll('[data-bs-toggle="popover"]').forEach(n=>{new bootstrap.Popover(n)})}function d(){document.querySelectorAll("form[data-validate]").forEach(e=>{e.addEventListener("submit",function(t){this.checkValidity()||(t.preventDefault(),t.stopPropagation(),api.showNotification("تنبيه","يرجى ملء جميع الحقول المطلوبة","warning")),this.classList.add("was-validated")})})}function p(){document.addEventListener("keydown",n=>{if((n.ctrlKey||n.metaKey)&&n.key==="k"){n.preventDefault();const e=document.querySelector("[data-search-input]");e&&e.focus()}n.key==="Escape"&&document.querySelectorAll(".modal.show").forEach(t=>{const s=bootstrap.Modal.getInstance(t);s&&s.hide()})})}window.initializeApp=u;window.setupFormValidation=d;
