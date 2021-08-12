
jQuery(document).ready(function() {

    try {
        var optionals = document.getElementsByName("optionals[]");
        var continueBtn = document.getElementById("continueToRequestBtn");
        // var formDiv = document.getElementById("requestForm");
        var form = document.getElementsByClassName("form")[0];
        
        const changeContinueBtn = () => {
            showContinueBtn = false;
            optionals.forEach((checkbox) => {
                if (checkbox.checked) showContinueBtn = true;
            });
        
            if (showContinueBtn) continueBtn.style = "display: block !important;";
            else continueBtn.style = "display: none !important;";
        }
        
        const changeOptional = (e) => {
            changeContinueBtn();
        }
        
        optionals.forEach((checkbox) => {
            checkbox.addEventListener("change", changeOptional);
        });
        changeContinueBtn();
        
        continueBtn.onclick = (e) => {
            var firstInput = form.getElementsByTagName("input")[0];
            tooltip = new bootstrap.Tooltip(form);
            
            var headerOffset = 45;
            var elementPosition = form.offsetTop;
            var offsetPosition = elementPosition - headerOffset;
            
            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth"
            });
            setTimeout(() => {
                firstInput.focus();
                tooltip.show;
                form.style = "border-color: #ce1000";
            }, 700);
        }
        
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            var clickedBtn = e.submitter;
            var type = clickedBtn.getAttribute("type")
            if (type == "submit") form.submit();
        });
    }
    catch(error) {
        console.error(error);
    }

    /*** Printing functions */
    
    try {
        
        // DEPRECATED
        function printElem(elem)
        {
            // var mywindow = window.open('', 'PRINT', 'height=3508,width=2480');
            var printWindow = window.open('', document.title);
        
            printWindow.document.write('<html><head>' + document.head.innerHTML  + '</head>');
            printWindow.document.write('<body class="printBody">' + elem.innerHTML + '</body></html>');
        
            printWindow.document.close(); // necessary for IE >= 10
            printWindow.focus(); // necessary for IE >= 10*/

            function fn() {

                printWindow.print();
                printWindow.close();
            }

            printWindow.document.addEventListener("DOMContentLoaded", fn);
            if (printWindow.document.readyState === "interactive" || printWindow.document.readyState === "complete" ) {
                fn();
            }
        
            return true;
        }
    }
    catch (error) {
        console.error(error);
    }
});