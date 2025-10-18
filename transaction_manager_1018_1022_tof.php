<?php
// 代码生成时间: 2025-10-18 10:22:17
class TransactionManager {

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $dbAdapter;

    /**
     * Constructor
     *
     * @param Zend_Db_Adapter_Abstract $dbAdapter
     */
    public function __construct(Zend_Db_Adapter_Abstract $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * Begin transaction
     *
     * @return void
     */
    public function beginTransaction() {
        try {
            $this->dbAdapter->beginTransaction();
        } catch (Exception $e) {
            // Handle error, e.g., log it or throw a custom exception
            error_log('Transaction begin failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Commit transaction
     *
     * @return void
     */
    public function commit() {
        try {
            $this->dbAdapter->commit();
        } catch (Exception $e) {
            // Handle error, e.g., log it or throw a custom exception
            error_log('Transaction commit failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Rollback transaction
     *
     * @return void
     */
    public function rollBack() {
        try {
            $this->dbAdapter->rollBack();
        } catch (Exception $e) {
            // Handle error, e.g., log it or throw a custom exception
            error_log('Transaction rollback failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Check if transaction is active
     *
     * @return bool
     */
    public function inTransaction() {
        return $this->dbAdapter->inTransaction();
    }
}
