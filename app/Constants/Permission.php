<?php

namespace App\Constants;

class Permission
{
    const FIRST_ASSESSOR_APPROVAL = "First Assessor Approval";
    const MANAGER_APPROVAL = "Manager Approval";
    const SECOND_ASSESSOR_APPROVAL = "Second Assessor Approval";
    const COMMITTEE_APPROVAL = "Committee Approval";
    const DG_APPROVAL = "DG Approval";
    const REVIEW_APPLICATION = "Review Application";
    const ASSIGN_APPLICATIONS = "Assign Applications";

    const MANAGE_USERS = "Manage Users";
    const MANAGE_ROLES = "Manage Roles";
    const MANAGE_PERMISSIONS = "Manage Permissions";
    const MANAGE_SERVICES = "Manage Services";
    const VIEW_APPLICANTS = "View Applicants";
    const EDIT_APPLICANT = "Edit Applicant";
    const VIEW_APPLICATIONS = "View Applications";
    const VIEW_APPLICATIONS_REPORT = "View Applications Report";

    const MANAGE_APPROVAL_LEVELS = "Manage Approval Levels";

    const MANAGE_DIVISIONS= "Manage Divisions";


    public static function all(): array
    {
        return [
            self::FIRST_ASSESSOR_APPROVAL,
            self::MANAGER_APPROVAL,
            self::SECOND_ASSESSOR_APPROVAL,
            self::COMMITTEE_APPROVAL,
            self::DG_APPROVAL,
            self::REVIEW_APPLICATION,
            self::ASSIGN_APPLICATIONS,
        ];
    }


    public static function approvalPermissions(): array
    {
        return [
            self::und,
            self::MANAGER_APPROVAL,
            self::SECOND_ASSESSOR_APPROVAL,
            self::COMMITTEE_APPROVAL,
            self::DG_APPROVAL,
            self::REVIEW_APPLICATION
        ];
    }


}
