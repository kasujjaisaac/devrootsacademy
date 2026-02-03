<!-- File removed: settings feature not functional -->

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save Changes</button>
        </form>
    </div>

    <!-- ================= ROLE & PERMISSIONS ================= -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">User Roles & Permissions</h2>
        <form action="{{ route('admin.settings.update', ['setting' => 'roles']) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-medium">Default Role for New Users</label>
                <select name="default_role" class="mt-1 w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="student" {{ ($settings['default_role'] ?? '') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="instructor" {{ ($settings['default_role'] ?? '') == 'instructor' ? 'selected' : '' }}>Instructor</option>
                    <option value="admin" {{ ($settings['default_role'] ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Allow User Registration</label>
                <select name="allow_registration" class="mt-1 w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="1" {{ ($settings['allow_registration'] ?? 1) == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ ($settings['allow_registration'] ?? 1) == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Update Roles</button>
        </form>
    </div>

    <!-- ================= SYSTEM PREFERENCES ================= -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">System Preferences</h2>
        <form action="{{ route('admin.settings.update', ['setting' => 'preferences']) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-medium">Default Currency</label>
                <select name="currency" class="mt-1 w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD</option>
                    <option value="UGX" {{ ($settings['currency'] ?? '') == 'UGX' ? 'selected' : '' }}>UGX</option>
                    <option value="EUR" {{ ($settings['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Enable Notifications</label>
                <select name="notifications_enabled" class="mt-1 w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="1" {{ ($settings['notifications_enabled'] ?? 1) == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ ($settings['notifications_enabled'] ?? 1) == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600">Save Preferences</button>
        </form>
    </div>

</div>
@endsection
