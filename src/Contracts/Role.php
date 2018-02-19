<?php

namespace MarkVilludo\Permission\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Role
{
    /**
     * A role may be given various permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany;

    /**
     * Find a role by its name and guard name.
     *
     * @param string $name
     * @param string|null $guardName
     *
     * @return \MarkVilludo\Permission\Contracts\Role
     *
     * @throws \MarkVilludo\Permission\Exceptions\RoleDoesNotExist
     */
    public static function findByName(string $name, $guardName): self;

    /**
     * Find a role by its id and guard name.
     * @param int $id
     * @param string|null $guardName
     *
     * @return \MarkVilludo\Permission\Contracts\Role
     *
     * @throws \MarkVilludo\Permission\Exceptions\RoleDoesNotExist
     */
    public static function findById(int $id, $guardName): self;

    /**
     * Determine if the user may perform the given permission.
     *
     * @param string|\MarkVilludo\Permission\Contracts\Permission $permission
     *
     * @return bool
     */
    public function hasPermissionTo($permission): bool;
}
