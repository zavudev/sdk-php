<?php

declare(strict_types=1);

namespace Zavudev\RegulatoryDocuments\RegulatoryDocumentCreateParams;

enum DocumentType: string
{
    case PASSPORT = 'passport';

    case NATIONAL_ID = 'national_id';

    case DRIVERS_LICENSE = 'drivers_license';

    case UTILITY_BILL = 'utility_bill';

    case TAX_ID = 'tax_id';

    case BUSINESS_REGISTRATION = 'business_registration';

    case PROOF_OF_ADDRESS = 'proof_of_address';

    case OTHER = 'other';
}
