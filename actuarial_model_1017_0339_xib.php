<?php
// 代码生成时间: 2025-10-17 03:39:27
class ActuarialModel 
{
    // Constants for calculation
    const MORTALITY_RATE = 0.01; // 1% mortality rate
    const CLAIM_RATE = 0.05; // 5% claim rate
    const CLAIM_AVERAGE_COST = 50000; // Average cost of a claim
    const PREMIUM_RATE = 0.02; // 2% premium rate

    /**
     * Calculate the total premium amount based on the risk and policy holder's age.
     *
     * @param float $riskLevel Risk level of the policy holder
     * @param int $age Age of the policy holder
     * @return float Calculated premium amount
     */
    public function calculatePremium($riskLevel, $age) 
    {
        // Validate input
        if ($riskLevel < 0 || $riskLevel > 1) {
            throw new InvalidArgumentException('Risk level must be between 0 and 1.');
        }

        if ($age < 0) {
            throw new InvalidArgumentException('Age cannot be negative.');
        }

        // Calculate premium based on risk level and age
        $premium = $riskLevel * self::PREMIUM_RATE * (1 + ($age / 100)); // Simplified age factor

        return $premium;
    }

    /**
     * Calculate the expected claims based on the mortality and claim rates.
     *
     * @param int $policyHolders Number of policy holders
     * @return float Expected claims amount
     */
    public function calculateExpectedClaims($policyHolders) 
    {
        // Validate input
        if ($policyHolders < 0) {
            throw new InvalidArgumentException('Number of policy holders cannot be negative.');
        }

        // Calculate expected claims
        $expectedClaims = $policyHolders * self::MORTALITY_RATE * self::CLAIM_RATE * self::CLAIM_AVERAGE_COST;

        return $expectedClaims;
    }
}

// Example usage
try {
    $model = new ActuarialModel();
    $premium = $model->calculatePremium(0.5, 30);
    $expectedClaims = $model->calculateExpectedClaims(1000);

    echo "Premium: \${$premium}\
";
    echo "Expected Claims: \${$expectedClaims}\
";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
