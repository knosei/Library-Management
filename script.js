function showForm(formId) {
    document.querySelectorAll(".form-group").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
}