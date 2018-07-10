<?php
/**
 * @author Chris Chabilall <chris.c@vanillaforums.com>
 * @copyright 2009-2018 Vanilla Forums Inc.
 * @license GPLv2
 */

namespace VanillaTests\Models;

use VanillaTests\SharedBootstrapTestCase;
use UserAuthenticationNonceModel;
use VanillaTests\SiteTestTrait;

/**
 * Test the {@link UserAuthenticationNonceModel}.
 */
class UserAuthenticationNonceModelTest extends SharedBootstrapTestCase {
    use SiteTestTrait;

    /**
     * Test nonce is issued and verified
     */
    public function testIssueAndVerify() {
        $model = new UserAuthenticationNonceModel('hhh');
        $nonce = $model->issue();
        $this->assertEquals(true,  $model->verify($nonce));
    }

    /**
     * That a nonce can be consumed.
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Nonce has expired.
     */
    public function testConsume() {
        $model = new UserAuthenticationNonceModel('hhh');
        $issuedNonce = $model->issue();
        $model->consume($issuedNonce);
        $consumedNonce = $model->getID($issuedNonce, DATASET_TYPE_ARRAY);
        $model->verify($consumedNonce['Nonce'], true, true);
    }
}
