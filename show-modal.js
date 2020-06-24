$("form").submit(function (evt) {
  evt.preventDefault();
  $("#addIncomeConfirmation").modal("show");
  $("#addExpenseConfirmation").modal("show");
});
