from django.db import models
from datetime import date
# Create your models here.
class Employee(models.Model):
    date= models.DateField(default=date.today)
    # employee_name = models.CharField(max_length=255)
    employee_unique_id = models.CharField(max_length=255)
    site_name = models.IntegerField()
    department =  models.IntegerField()
    profile = models.ImageField(upload_to="emp_images/", null=True, blank=True)
    created_dt = models.DateTimeField(auto_now_add=True, blank=False)
    modified_dt = models.DateTimeField(max_length=500, null=True)
    created_by = models.IntegerField(blank=False)
    modified_by = models.IntegerField(blank=False, null=True)
    Yes = "Yes"
    No = "No"
    status_CHOICES = [
        (Yes, "Yes"),
        (No, "No"),
    ]
    delete_status = models.CharField(
        max_length=50, choices=status_CHOICES, default="No"
    )

    class Meta:
        db_table = "payroll_employee"