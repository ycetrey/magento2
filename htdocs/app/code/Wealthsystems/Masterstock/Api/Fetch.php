<?php

namespace Wealthsystems\Masterstock\Api;

interface Fetch
{
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return string Greeting message with users name.
     */
    public function execute($product);
}
