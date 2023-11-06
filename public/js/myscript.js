const formSelector = document.getElementById("roleSelect");
        const form1 = document.getElementById("tupIDdiv");
        const form2 = document.getElementById("courseform");
        const form3 = document.getElementById("yearform");
        const rowCourse = document.getElementById("rowAndCourse");
        const divOrg = document.getElementById("divOrg");
        const section = document.getElementById("sectionform");

        formSelector.addEventListener("change", () => {
            const selectedFormId = formSelector.value;
            const selectedForm = document.getElementById(selectedFormId);

            // alert(selectedFormId)
            if (selectedFormId === "Professor") {
                // alert("sj")
                // selectedForm.style.display = "block";
                rowCourse.setAttribute("hidden", "true");
                section.setAttribute("hidden", "true");
                divOrg.removeAttribute("hidden");
                // alert("nice")
            }
            else if (selectedFormId === "Admin/Staff") {
                // alert("Admin")
                section.setAttribute("hidden", "true");
                rowCourse.setAttribute("hidden", "true");
                divOrg.setAttribute("hidden", "true");
            }
            else if (selectedFormId === "Student"){
                // alert("student")
                section.removeAttribute("hidden", "true");
                rowCourse.removeAttribute("hidden");
                divOrg.removeAttribute("hidden");
            }
            
        
        });
