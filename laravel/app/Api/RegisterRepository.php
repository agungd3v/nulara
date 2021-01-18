<?php

namespace App\Api;

use DB;

class RegisterRepository  extends ApiQueryRepository {
    public function praSaveMO()
    {
        $lastMemberOrder    = $this->getMemberOrdersLastId();
        $uniqCode   = 1;
        if ($lastMemberOrder) {
            $uniqCode   = $lastMemberOrder->id + 1;
        }
        if (!$lastMemberOrder) {
            $lastMemberOrder        = new \stdClass();
            $lastMemberOrder->id    = 999;
        }
        $inv    = $this->_makeInvoice($lastMemberOrder->id);
        $rates  = MyHelpers::getRates('usd');
        return [
            'unique-code'   => $uniqCode,
            'invoice'   => $inv,
            'rates' => $rates
        ];
    }
    private function _createOrgUsers($request, $mo, $utmRef = '')
    {
        $return     = [
            'success'   => false,
            'message'   => ''
        ];

        try {
            $newOrgUser = new OrgUsers();
            $newOrgUser->name   = $request->get('name');
            $newOrgUser->email  = $request->get('email');
            $newOrgUser->phone  = $request->get('phone');
            $newOrgUser->country_code   = $request->get('country');
            $newOrgUser->city   = $request->get('city');
            $newOrgUser->membership_package = $request->get('package_name');
            $newOrgUser->site_role  = $this->_getSiteRoleByPackage($request->get('package_name'));
            $newOrgUser->must_answer   = $request->get('package_name') == 'Gold' ? 1 : 0;
            $newOrgUser->marking_code   = $request->get('marking_code');
            $newOrgUser->password   = $request->get('password_hash');
            $newOrgUser->com_expired_at = $this->_getComExpiredAtByPackage($request->get('package_name'));
            // Check if exist discount
            if($request->get('package_name') == 'Gold'){
                $newOrgUser->package = MyHelpers::lablePackageMemberByCountry($request->input('country'));
            }
            if ($mo->discount_amount) {
                $newOrgUser->sales_ref = '';
            }

            $newOrgUser->utm_ref    = $utmRef;

            $newOrgUser->save();

            $return['success']  = true;
            $return['message']  = $newOrgUser;
            return $return;
        } catch (\Exception $e) {
            $return['message']  = $e->getMessage();
            return $return;
        }
    }
}