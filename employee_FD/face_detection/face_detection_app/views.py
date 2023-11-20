from django.shortcuts import render,redirect,HttpResponse
from django.db import connection
from .models import Employee
import shutil
from django.conf import settings
import os
import base64
import cv2
import numpy as np
import face_recognition
from datetime import datetime
# Create your views here.
def index(request):
    cursor = connection.cursor()
    cursor.execute("SELECT * From `site_creation` ")
    site_details = cursor.fetchall()
    cursor = connection.cursor()
    cursor.execute("SELECT * From `designation_creation` ")
    designation_details = cursor.fetchall()
    if request.method == "POST":
        date = request.POST.get("date")
        employee_id = request.POST.get("emp_id")
        site_name = request.POST.get("site_name")
        dept_name = request.POST.get("dept_name")
        img_src = request.POST.get("image_data")
        img_list = img_src.split(", ")
        print("imgae data : ",img_list[0])
        img_list1 = img_list[0]
        img_data = img_list1.split(",")
        print("imgae data1 : ",img_data)
        img_data1 = img_data[1]
        # return HttpResponse(img_data[1])
        image_data = base64.b64decode(img_data1)

        # Create the target directory if it doesn't exist
        target_directory = "media/emp_images"
        os.makedirs(target_directory, exist_ok=True)

        # Save the image file
        file_name = employee_id+".png"  # Provide a suitable file name
        file_path = os.path.join(target_directory, file_name)

        with open(file_path, "wb") as file:
            file.write(image_data)

        print("Image saved successfully.")
        emp = Employee()
        emp.date = date
        emp.employee_unique_id = employee_id
        emp.site_name = site_name
        emp.department = dept_name
        emp.created_by = '1'
        emp.profile = 'emp_images/'+file_name
        emp.save()
        # return HttpResponse("Success")
        return redirect('emp_list')
    else:
        return render(request,"index.html",{'site_details':site_details,'designation_details':designation_details})


def emp_list(request):
    emp_list = Employee.objects.filter(delete_status="No").values()
    return render(request,"emp_list.html",{"emp_list":emp_list})

def delete_list(request,id):
    employee_id_to_update = id  # Replace with the actual employee ID you want to update

# Update query
    Employee.objects.filter(id=employee_id_to_update).update(delete_status="Yes")
    # Employee.objects.filter(delete_status="No").update(delete_status="Yes")
    # cursor.execute(
    #     "UPDATE area_list SET delete_status='Yes' where id='{}'".format(id))
    return HttpResponse("Deleted Successfully")
