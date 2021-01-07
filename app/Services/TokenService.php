<?php

namespace App\Services;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class TokenService
{
    public function getToken()
    {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
        );

        $now = new \DateTimeImmutable();
        $token = $config->builder()
            ->issuedBy('127.0.0.1:800')
            ->permittedFor('127.0.0.1:800')
            ->identifiedBy('4f1g23a12aa')
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('uid', 1)
            ->withHeader('foo', 'bar')
            ->getToken($config->signer(), $config->signingKey());

        return $token->toString();
    }
}
