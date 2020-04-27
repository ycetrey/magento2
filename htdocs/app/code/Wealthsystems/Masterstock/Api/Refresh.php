<?php

namespace Wealthsystems\Masterstock\Api;

interface Refresh
{
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return string Greeting message with users name.
     */
    public function execute($stock);
}
