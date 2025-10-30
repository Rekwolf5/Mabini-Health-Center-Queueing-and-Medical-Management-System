# 🎭 Multi-Role System Setup Guide

## 🚀 Complete Role-Based System

Your Mabini Health Center now has a comprehensive multi-role system with:

### 👥 **Three User Types:**

#### 🏥 **Patients**
- **Register/Login**: Self-registration with email/password
- **Dashboard**: View queue status, position, and medical history
- **Profile Management**: Update contact info and address
- **Queue Status**: Real-time queue position and wait times
- **Medical History**: View past consultations and treatments

#### 👩‍⚕️ **Staff** 
- **Queue Management**: Call next patient, mark served/no-show
- **Patient History**: View complete medical records
- **Consultation Notes**: Add diagnosis, treatment, and notes
- **Medicine Inventory**: Update stock levels with reasons
- **Print Queue**: Generate printable queue lists

#### 👨‍💼 **Admin**
- **User Management**: Create, edit, delete staff accounts
- **Real-time Monitoring**: Live queue status dashboard
- **Medicine Control**: Approve/reject stock changes
- **System Reports**: Generate comprehensive analytics
- **Activity Logs**: Monitor all system activities
- **System Settings**: Configure clinic information
- **Backup/Restore**: Database backup and restore functionality

## 🔐 **Login Credentials:**

### Staff/Admin Portal: `/login`
- **Admin**: admin@mabini.com / password
- **Staff**: staff@mabini.com / password

### Patient Portal: `/patient/login`
- **Sample Patient**: maria.santos@example.com / password
- **Or register new account**: `/patient/register`

## 🛠️ **Setup Instructions:**

### 1. **Run Migrations**
\`\`\`bash
php artisan migrate:fresh --seed
\`\`\`

### 2. **Start Server**
\`\`\`bash
php artisan serve
\`\`\`

### 3. **Access Portals**
- **Patient Portal**: http://localhost:8000/patient/login
- **Staff/Admin Portal**: http://localhost:8000/login

## ✨ **Key Features:**

### 🔒 **Security**
- Separate authentication guards for patients and staff
- Role-based access control (Admin, Staff, Patient)
- Activity logging for all actions
- Session management and security

### 📊 **Real-time Updates**
- Live queue status monitoring
- Automatic position updates for patients
- Real-time stock level tracking
- Activity logging with timestamps

### 📱 **Mobile Responsive**
- All interfaces work on mobile devices
- Touch-friendly buttons and forms
- Responsive layouts for all screen sizes

### 🎯 **Workflow Management**
- **Patient Flow**: Register → Login → View Queue Status
- **Staff Flow**: Login → Manage Queue → Add Notes → Update Inventory
- **Admin Flow**: Login → Monitor System → Manage Users → Generate Reports

## 🔧 **Advanced Features:**

### 📋 **Queue Management**
- Priority-based queue (Emergency > Urgent > Normal)
- Status tracking (Waiting → Consulting → Completed)
- No-show marking and tracking
- Estimated wait times for patients

### 💊 **Medicine Inventory**
- Stock level monitoring with alerts
- Expiry date tracking
- Staff can update with reasons
- Admin approval system for changes

### 📈 **Reporting & Analytics**
- Patient demographics and statistics
- Queue performance metrics
- Medicine usage and inventory reports
- System activity and audit logs

### ⚙️ **System Administration**
- Configurable system settings
- User account management
- Database backup and restore
- Activity monitoring and logging

## 🎉 **Ready to Use!**

Your multi-role health center system is now complete with:
- ✅ Patient self-service portal
- ✅ Staff queue and inventory management
- ✅ Admin system oversight and control
- ✅ Real-time updates and monitoring
- ✅ Comprehensive reporting
- ✅ Mobile-responsive design
- ✅ Security and audit logging

Perfect for healthcare facilities, clinics, and student capstone projects! 🌟
