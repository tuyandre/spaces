<?php

namespace App\Traits;

use App\Constants\Status;

trait HasStatusColor
{
    public function getStatusColorAttribute(): string
    {
        $status = strtolower($this->status);
        if ($status == Status::Draft) {
            return 'warning';
        } elseif ($status == Status::Submitted) {
            return 'info';
        } elseif ($status == Status::UnderReview) {
            return 'info';
        } elseif ($status == Status::ProposeToApprove) {
            return 'info';
        } elseif ($status == Status::Approved) {
            return 'success';
        } elseif ($status == Status::Rejected) {
            return 'danger';
        } elseif ($status == Status::ProposeToReject) {
            return 'warning';
        } elseif ($status == Status::ReturnBack) {
            return 'warning';
        } elseif ($status == Status::ReturnBackToApplicant) {
            return 'warning';
        } elseif ($status == Status::ProposeToReturnBack) {
            return 'warning';
        } elseif ($status == Status::Cancelled) {
            return 'danger';
        } elseif ($status == "inactive") {
            return 'danger';
        } elseif ($status == "active") {
            return 'success';
        }
        return 'secondary';
    }
}
