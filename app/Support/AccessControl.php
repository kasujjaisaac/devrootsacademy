<?php

namespace App\Support;

class AccessControl
{
    public const ACCESS_ADMIN_PANEL = 'access_admin_panel';
    public const VIEW_DASHBOARD = 'view_dashboard';
    public const MANAGE_STUDENTS = 'manage_students';
    public const MANAGE_STUDENT_APPLICATIONS = 'manage_student_applications';
    public const MANAGE_COURSES = 'manage_courses';
    public const MANAGE_LECTURE_RECORDINGS = 'manage_lecture_recordings';
    public const MANAGE_TIMETABLES = 'manage_timetables';
    public const MANAGE_PARTNERS = 'manage_partners';
    public const MANAGE_INSTRUCTORS = 'manage_instructors';
    public const MANAGE_INSTRUCTOR_APPLICATIONS = 'manage_instructor_applications';
    public const MANAGE_ENROLLMENTS = 'manage_enrollments';
    public const MANAGE_PAYMENTS = 'manage_payments';
    public const VIEW_REPORTS = 'view_reports';
    public const MANAGE_MESSAGES = 'manage_messages';
    public const MANAGE_SETTINGS = 'manage_settings';
    public const MANAGE_STAFF_USERS = 'manage_staff_users';

    public static function permissions(): array
    {
        return [
            self::ACCESS_ADMIN_PANEL => 'Access admin panel',
            self::VIEW_DASHBOARD => 'View dashboard',
            self::MANAGE_STUDENTS => 'Manage students',
            self::MANAGE_STUDENT_APPLICATIONS => 'Manage student applications',
            self::MANAGE_COURSES => 'Manage courses',
            self::MANAGE_LECTURE_RECORDINGS => 'Manage lecture recordings',
            self::MANAGE_TIMETABLES => 'Manage timetables',
            self::MANAGE_PARTNERS => 'Manage partners',
            self::MANAGE_INSTRUCTORS => 'Manage instructors',
            self::MANAGE_INSTRUCTOR_APPLICATIONS => 'Manage instructor applications',
            self::MANAGE_ENROLLMENTS => 'Manage enrollments',
            self::MANAGE_PAYMENTS => 'Manage payments',
            self::VIEW_REPORTS => 'View reports',
            self::MANAGE_MESSAGES => 'Manage messages',
            self::MANAGE_SETTINGS => 'Manage settings',
            self::MANAGE_STAFF_USERS => 'Manage staff users',
        ];
    }

    public static function roles(): array
    {
        return [
            'super_admin' => [
                'name' => 'Super Admin',
                'permissions' => array_keys(self::permissions()),
            ],
            'finance_officer' => [
                'name' => 'Finance Officer',
                'permissions' => [
                    self::ACCESS_ADMIN_PANEL,
                    self::VIEW_DASHBOARD,
                    self::MANAGE_PAYMENTS,
                    self::VIEW_REPORTS,
                ],
            ],
            'academic_head' => [
                'name' => 'Academic Head',
                'permissions' => [
                    self::ACCESS_ADMIN_PANEL,
                    self::VIEW_DASHBOARD,
                    self::MANAGE_STUDENTS,
                    self::MANAGE_COURSES,
                    self::MANAGE_LECTURE_RECORDINGS,
                    self::MANAGE_TIMETABLES,
                    self::MANAGE_ENROLLMENTS,
                    self::MANAGE_INSTRUCTORS,
                    self::VIEW_REPORTS,
                ],
            ],
            'admissions_officer' => [
                'name' => 'Admissions Officer',
                'permissions' => [
                    self::ACCESS_ADMIN_PANEL,
                    self::VIEW_DASHBOARD,
                    self::MANAGE_STUDENT_APPLICATIONS,
                    self::MANAGE_INSTRUCTOR_APPLICATIONS,
                    self::MANAGE_MESSAGES,
                    self::VIEW_REPORTS,
                ],
            ],
            'registrar' => [
                'name' => 'Registrar',
                'permissions' => [
                    self::ACCESS_ADMIN_PANEL,
                    self::VIEW_DASHBOARD,
                    self::MANAGE_STUDENTS,
                    self::MANAGE_ENROLLMENTS,
                    self::MANAGE_TIMETABLES,
                    self::VIEW_REPORTS,
                ],
            ],
            'support_officer' => [
                'name' => 'Support Officer',
                'permissions' => [
                    self::ACCESS_ADMIN_PANEL,
                    self::MANAGE_MESSAGES,
                ],
            ],
            'reports_analyst' => [
                'name' => 'Reports Analyst',
                'permissions' => [
                    self::ACCESS_ADMIN_PANEL,
                    self::VIEW_DASHBOARD,
                    self::VIEW_REPORTS,
                ],
            ],
            'content_admin' => [
                'name' => 'Content Admin',
                'permissions' => [
                    self::ACCESS_ADMIN_PANEL,
                    self::VIEW_DASHBOARD,
                    self::MANAGE_PARTNERS,
                    self::MANAGE_COURSES,
                    self::MANAGE_LECTURE_RECORDINGS,
                ],
            ],
        ];
    }
}
