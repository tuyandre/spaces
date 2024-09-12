<?php

namespace App\Constants;

class Status
{
    const Draft = 'Draft';
    const Pending = 'Pending';
    const Submitted = 'Submitted';
    const AwaitingFinanceVerification = 'Awaiting Finance Verification';
    const InProgress = 'In Progress';
    const Screening = 'Screening';
    const Querying = 'Querying';
    const Rejected = 'Rejected';
    const UnderReview = 'Under Review';
    const FirstAssessment = 'First Assessment';
    const SecondAssessment = 'Second Assessment';
    const SchedulingPeerReview = 'Scheduling Peer Review';
    const PeerReview = 'Peer Review';
    const HODApproval = 'HOD Approval';
    const DeputyDGReview = 'Deputy DG Review';
    const LegalReview = 'Legal Review';
    const DGApproval = 'DG Approval';
    const Approved = 'Approved';
    const FinalApproval = 'Final Approval';
    const ReturnBack = 'Return Back';
    const ReturnBackToApplicant = 'Return Back To Applicant';
    const ProposeToApprove = 'Propose to Approve';
    const ProposeToReject = 'Propose To Reject';
    const ProposeToReturnBack = 'Propose To Return Back';
    const Cancelled = 'Cancelled';

    public static function reviewStatuses(): array
    {
        return [
            self::UnderReview,
            self::ProposeToApprove,
            self::ProposeToReject,
            self::ProposeToReturnBack,
            self::ReturnBack
        ];
    }

    public static function all()
    {
        return [
            self::Draft,
            self::Submitted,
            self::AwaitingFinanceVerification,
            self::InProgress,
            self::Screening,
            self::Querying,
            self::Rejected,
            self::UnderReview,
            self::FirstAssessment,
            self::SecondAssessment,
            self::SchedulingPeerReview,
            self::PeerReview,
            self::HODApproval,
            self::DeputyDGReview,
            self::LegalReview,
            self::DGApproval,
            self::Approved,
            self::FinalApproval,
            self::ReturnBack,
            self::ReturnBackToApplicant,
            self::ProposeToApprove,
            self::ProposeToReject,
            self::ProposeToReturnBack,
            self::Cancelled
        ];
    }


}
